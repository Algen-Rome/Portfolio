import { initializeApp } from "https://www.gstatic.com/firebasejs/12.14.0/firebase-app.js";
import { getFirestore } from "https://www.gstatic.com/firebasejs/12.14.0/firebase-firestore.js";
import { getAuth } from "https://www.gstatic.com/firebasejs/12.14.0/firebase-auth.js";

const firebaseConfig = {
  apiKey: "AIzaSyAunV9UMRwDeYosvZlKwwj3GVcAk8bQInM",
  authDomain: "portfolio-ae9b9.firebaseapp.com",
  projectId: "portfolio-ae9b9",
  storageBucket: "portfolio-ae9b9.firebasestorage.app",
  messagingSenderId: "755067453032",
  appId: "1:755067453032:web:29717d143cd51b6db605dd"
};

const app = initializeApp(firebaseConfig);
export const db = getFirestore(app);
export const auth = getAuth(app);