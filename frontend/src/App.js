import { useState } from "react";

function App() {
  // ====== STATE ======
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [tasks, setTasks] = useState([]);
  const [title, setTitle] = useState("");

  // ====== REGISTER ======
  const register = async () => {
    try {
      const res = await fetch("http://127.0.0.1:8000/api/register", {
        method: "POST",
        headers: {
          "Content-Type": "application/json", 
          "Accept": "application/json"
        },
        body: JSON.stringify({
          name: "Test User",
          email,
          password
        })
      });

      const data = await res.json();
      console.log("REGISTER:", data);
      alert("User registered!");
    } catch (err) {
      console.error("Register error:", err);
    }
  };

  // ====== LOGIN ======
  const login = async () => {
    try {
      const res = await fetch("http://127.0.0.1:8000/api/login", {
        method: "POST",
        headers: {
          "Content-Type": "application/json", // түзетілген
          "Accept": "application/json"
        },
        body: JSON.stringify({ email, password })
      });

      const data = await res.json();
      console.log("LOGIN:", data);

      if (res.ok && data.token) {
        localStorage.setItem("token", data.token);
        alert("Login successful!");
      } else {
        alert(data.message || "Login failed");
      }
    } catch (err) {
      console.error("Login error:", err);
    }
  };

  // ====== GET TASKS ======
  const getTasks = async () => {
    try {
      const res = await fetch("http://127.0.0.1:8000/api/tasks", {
        headers: {
          "Authorization": "Bearer " + localStorage.getItem("token"),
          "Accept": "application/json"
        }
      });

      const data = await res.json();
      console.log("TASKS:", data);
      setTasks(Array.isArray(data) ? data : []);
    } catch (err) {
      console.error("Get tasks error:", err);
    }
  };

  // ====== ADD TASK ======
  const addTask = async () => {
    try {
      const res = await fetch("http://127.0.0.1:8000/api/tasks", {
        method: "POST", 
        headers: {
          "Content-Type": "application/json",
          "Accept": "application/json",
          "Authorization": "Bearer " + localStorage.getItem("token")
        },
        body: JSON.stringify({ title })
      });

      const data = await res.json();
      console.log("NEW TASK:", data);
      if (res.ok) getTasks(); // жаңартылған таскіні шығару
    } catch (err) {
      console.error("Add task error:", err);
    }
  };
  
  const deleteTask = async (id) => {
  try {
    await fetch(`http://127.0.0.1:8000/api/tasks/${id}`, {
      method: "DELETE",
      headers: {
        "Authorization": "Bearer " + localStorage.getItem("token"),
        "Accept": "application/json"
      }
    });

     getTasks();
  } catch (err) {
    console.error("Delete error:", err);
  }
};
  
  // ====== JSX RETURN ======
  return (
    <div style={{ padding: "20px" }}>
      <h1>Auth</h1>

      <input placeholder="Email" onChange={(e) => setEmail(e.target.value)} />
      <input placeholder="Password" type="password" onChange={(e) => setPassword(e.target.value)} />

      <button onClick={register}>Register</button>
      <button onClick={login}>Login</button>

      <hr />

      <h2>Add Task</h2>
      <input 
      placeholder="Task title" 
      onChange={(e) => setTitle(e.target.value)} />
      
      <button onClick={addTask}>Add Task</button>
      <button onClick={getTasks}>Get Tasks</button>

      {tasks.map((task) => (
        <div key={task.id}>
        <p>{task.title}</p>
        <button onClick={() => deleteTask(task.id)}>Delete</button>
</div>
))}
</div>
);
}

export default App;