(() => {
  const uploadBox = document.getElementById("uploadBox");
  const fileInput = document.getElementById("fileInput");
  const filesTableBody = document.querySelector("#filesTable tbody");
  const searchInput = document.getElementById("search");
  const totalCount = document.getElementById("totalCount");

  const STORAGE_KEY = "student_files_demo";

  function formatBytes(bytes) {
    const units = ["B", "KB", "MB", "GB"];
    let i = 0;
    while (bytes >= 1024) {
      bytes /= 1024;
      i++;
    }
    return bytes.toFixed(1) + units[i];
  }

  function loadFiles() {
    return JSON.parse(localStorage.getItem(STORAGE_KEY) || "[]");
  }

  function saveFiles(files) {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(files));
  }

  function renderTable(filter = "") {
    const files = loadFiles().filter(f =>
      f.name.toLowerCase().includes(filter.toLowerCase())
    );

    filesTableBody.innerHTML = "";
    files.forEach((file, index) => {
      const tr = document.createElement("tr");

      tr.innerHTML = `
        <td>${file.name}</td>
        <td>${file.size}</td>
        <td>${file.date}</td>
        <td class="actions">
          <button class="edit" data-i="${index}">✏️</button>
          <button class="download" data-i="${index}">⬇️</button>
          <button class="delete" data-i="${index}">🗑️</button>
        </td>
      `;
      filesTableBody.appendChild(tr);
    });

    totalCount.textContent = `(${loadFiles().length})`;
  }

  function addFiles(fileList) {
    const files = loadFiles();

    [...fileList].forEach(file => {
      const reader = new FileReader();
      reader.onload = e => {
        files.push({
          name: file.name,
          size: formatBytes(file.size),
          date: new Date().toLocaleDateString("fr-FR"),
          dataUrl: e.target.result
        });
        saveFiles(files);
        renderTable(searchInput.value);
      };
      reader.readAsDataURL(file);
    });
  }

  // Events
  uploadBox.onclick = () => fileInput.click();
  fileInput.onchange = e => addFiles(e.target.files);

  uploadBox.addEventListener("dragover", e => {
    e.preventDefault();
    uploadBox.style.borderColor = "#999";
  });

  uploadBox.addEventListener("dragleave", () => {
    uploadBox.style.borderColor = "#ccc";
  });

  uploadBox.addEventListener("drop", e => {
    e.preventDefault();
    uploadBox.style.borderColor = "#ccc";
    addFiles(e.dataTransfer.files);
  });

  filesTableBody.onclick = e => {
    const btn = e.target.closest("button");
    if (!btn) return;

    const index = btn.dataset.i;
    const files = loadFiles();

    if (btn.classList.contains("delete")) {
      if (confirm("Supprimer ce fichier ?")) {
        files.splice(index, 1);
        saveFiles(files);
        renderTable(searchInput.value);
      }
    }

    if (btn.classList.contains("edit")) {
      const newName = prompt("Renommer le fichier :", files[index].name);
      if (newName) {
        files[index].name = newName;
        saveFiles(files);
        renderTable(searchInput.value);
      }
    }

    if (btn.classList.contains("download")) {
      const a = document.createElement("a");
      a.href = files[index].dataUrl;
      a.download = files[index].name;
      a.click();
    }
  };

  searchInput.oninput = () => renderTable(searchInput.value);

  // Initial load
  if (loadFiles().length === 0) {
    saveFiles([
      { name: "Attestation_bac.pdf", size: "5.4MB", date: "18/11/2025", dataUrl: "" },
      { name: "Licence.pdf", size: "3.0MB", date: "09/10/2025", dataUrl: "" }
    ]);
  }

  renderTable();
})();
