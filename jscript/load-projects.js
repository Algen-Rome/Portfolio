import { db } from './firebase-config.js';
import { collection, getDocs } from "https://www.gstatic.com/firebasejs/12.14.0/firebase-firestore.js";

async function loadProjects() {
  const list = document.querySelector('.project-list');
  list.innerHTML = '';

  const snapshot = await getDocs(collection(db, "projects"));

  snapshot.forEach((docSnap) => {
    const data = docSnap.data();
    const item = document.createElement('div');
    item.innerHTML = `
  <img src="${data.image}" alt="${data.title}" style="width:100%; border-radius:8px; margin-bottom:10px;">
  <h3>${data.title}</h3>
  <p>${data.description}</p>
  <a href="${data.link}" target="_blank" style="color:#FF5F1F;">View Project</a>
`;
    list.appendChild(item);
  });
}

loadProjects();
