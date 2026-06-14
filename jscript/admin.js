import { auth, db } from './firebase-config.js';
import { signInWithEmailAndPassword, onAuthStateChanged, signOut }
  from "https://www.gstatic.com/firebasejs/12.14.0/firebase-auth.js";
import { collection, addDoc, getDocs, deleteDoc, doc }
  from "https://www.gstatic.com/firebasejs/12.14.0/firebase-firestore.js";

const loginSection = document.getElementById('login-section');
const adminSection = document.getElementById('admin-section');
const loginError = document.getElementById('login-error');

onAuthStateChanged(auth, (user) => {
  if (user) {
    loginSection.style.display = 'none';
    adminSection.style.display = 'block';
    loadProjects();
  } else {
    loginSection.style.display = 'block';
    adminSection.style.display = 'none';
  }
});

document.getElementById('login-btn').addEventListener('click', () => {
  const email = document.getElementById('email').value;
  const password = document.getElementById('password').value;

  signInWithEmailAndPassword(auth, email, password)
    .catch((error) => {
      loginError.textContent = error.message;
    });
});

document.getElementById('logout-btn').addEventListener('click', () => {
  signOut(auth);
});

document.getElementById('add-btn').addEventListener('click', async () => {
  const title = document.getElementById('title').value;
  const description = document.getElementById('description').value;
  const image = document.getElementById('image').value;
  const link = document.getElementById('link').value;

  if (!title) return;

  await addDoc(collection(db, "projects"), { title, description, image, link });

  document.getElementById('title').value = '';
  document.getElementById('description').value = '';
  document.getElementById('image').value = '';
  document.getElementById('link').value = '';

  loadProjects();
});

async function loadProjects() {
  const list = document.getElementById('project-list');
  list.innerHTML = '';

  const snapshot = await getDocs(collection(db, "projects"));

  snapshot.forEach((docSnap) => {
    const data = docSnap.data();
    const item = document.createElement('div');
    item.style.marginBottom = '10px';
    item.innerHTML = `
      <strong>${data.title}</strong> - ${data.description}
      <button data-id="${docSnap.id}" class="delete-btn">Delete</button>
    `;
    list.appendChild(item);
  });

  document.querySelectorAll('.delete-btn').forEach((btn) => {
    btn.addEventListener('click', async (e) => {
      await deleteDoc(doc(db, "projects", e.target.dataset.id));
      loadProjects();
    });
  });
}