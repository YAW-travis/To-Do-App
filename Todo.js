document.addEventListener("DOMContentLoaded", function () {
    loadTasks();

    document.getElementById("createReminder").addEventListener("click", function () {
        let task = prompt("Enter task:");
        let category = prompt("Enter category (e.g., Work, Grocery, Personal):");

        if (task && category) {
            let tasks = JSON.parse(localStorage.getItem("tasks")) || [];
            tasks.push({ task, category, completed: false });
            localStorage.setItem("tasks", JSON.stringify(tasks));
            loadTasks();
        }
    });
});

function loadTasks() {
    let tasks = JSON.parse(localStorage.getItem("tasks")) || [];
    let taskList = document.getElementById("taskList");
    let completedTasks = document.getElementById("completedTasks");

    taskList.innerHTML = "";
    completedTasks.innerHTML = "";

    tasks.forEach((task, index) => {
        let div = document.createElement("div");
        div.classList.add("task-item");
        div.innerHTML = `
            <span>${task.task} - <strong>${task.category}</strong></span>
            <button onclick="completeTask(${index})">✓</button>
        `;

        if (task.completed) {
            div.classList.add("completed");
            completedTasks.appendChild(div);
        } else {
            taskList.appendChild(div);
        }
    });
}

function completeTask(index) {
    let tasks = JSON.parse(localStorage.getItem("tasks")) || [];
    tasks[index].completed = true;
    localStorage.setItem("tasks", JSON.stringify(tasks));
    loadTasks();
}
