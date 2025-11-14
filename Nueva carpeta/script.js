document.getElementById("articleForm")?.addEventListener("submit", e => {
  e.preventDefault();

  const title = document.getElementById("title").value;
  const image = document.getElementById("image").value;
  const content = document.getElementById("content").value;

  if (title === "" || content === "") {
    alert("fill all fields!");
    return;
  }

  const article = { title, image, content, date: new Date().toLocaleDateString() };

  localStorage.setItem("article", JSON.stringify(article));
  alert(" Spot published!");
  window.location.href = "index.html";
});

if (document.getElementById("articles")) {
  const data = localStorage.getItem("article");
  if (data) {
    const a = JSON.parse(data);
    document.getElementById("articles").innerHTML = `
      <div class="article-preview">
        <img src="${a.image || 'images/default.jpg'}" alt="${a.title}">
        <h2>${a.title}</h2>
        <p class="meta">Posted on ${a.date}</p>
        <p>${a.content.substring(0,100)}...</p>
        <a href="article.html" class="btn">Read More</a>
      </div>`;
  }
}

if (document.getElementById("article-view")) {
  const data = localStorage.getItem("article");
  if (data) {
    const a = JSON.parse(data);
    document.getElementById("article-view").innerHTML = `
      <h1>${a.title}</h1>
      <img src="${a.image || 'images/default.jpg'}" alt="${a.title}">
      <p>${a.content}</p>`;
  }
}

document.getElementById("commentForm")?.addEventListener("submit", e => {
  e.preventDefault();

  const name = document.getElementById("username").value.trim();
  const comment = document.getElementById("commentText").value.trim();

  if (name === "" || comment === "") return alert("fill all fields.");

  const div = document.createElement("div");
  div.classList.add("comment");
  div.innerHTML = `<p><strong>${name}:</strong> ${comment}</p>`;
  document.getElementById("comments-list").appendChild(div);

  document.getElementById("commentForm").reset();
});

document.getElementById("loginForm")?.addEventListener("submit", e => {
  e.preventDefault();
  const email = document.getElementById("email").value;
  const pass = document.getElementById("password").value;
  const msg = document.getElementById("message");

  if (!email.includes("@") || pass.length < 4) {
    msg.textContent = "Invalid credentials!";
    msg.style.color = "red";
  } else {
    msg.textContent = "Logged in successfully!";
    msg.style.color = "green";
  }
});
