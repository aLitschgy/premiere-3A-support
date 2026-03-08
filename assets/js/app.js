// Gestion des notifications
function showNotification(message, type = "error") {
  const notification = document.getElementById("notification");
  notification.textContent = message;
  notification.className = `notification ${type} show`;

  // Disparaître après 10 secondes
  setTimeout(() => {
    notification.classList.add("hide");
    setTimeout(() => {
      notification.classList.remove("show", "hide");
    }, 300);
  }, 10000);
}

// Vérifier les paramètres URL pour afficher les notifications
document.addEventListener("DOMContentLoaded", () => {
  const urlParams = new URLSearchParams(window.location.search);

  if (urlParams.get("success")) {
    showNotification("Votre ticket a été envoyé avec succès.", "success");
    // Nettoyer l'URL
    window.history.replaceState({}, document.title, window.location.pathname);
  }

  if (urlParams.get("error")) {
    // Récupérer le message d'erreur depuis le serveur (via session PHP)
    fetch("get_message.php")
      .then((response) => response.json())
      .then((data) => {
        if (data.error) {
          showNotification(data.error, "error");
        }
      })
      .catch(() => {
        showNotification(
          "Une erreur est survenue. Veuillez réessayer.",
          "error",
        );
      });
    // Nettoyer l'URL
    window.history.replaceState({}, document.title, window.location.pathname);
  }
});

// Validation côté client de la taille des fichiers
document.getElementById("ticketForm")?.addEventListener("submit", (e) => {
  const files = document.getElementById("attachments").files;
  const maxTotalSize = 20 * 1024 * 1024; // 20 MB
  const maxFileSize = 10 * 1024 * 1024; // 10 MB
  let totalSize = 0;

  for (let i = 0; i < files.length; i++) {
    const file = files[i];

    if (file.size > maxFileSize) {
      e.preventDefault();
      showNotification(
        `Le fichier "${file.name}" est trop volumineux (max: 10 MB par fichier).`,
        "error",
      );
      return;
    }

    totalSize += file.size;
  }

  if (totalSize > maxTotalSize) {
    e.preventDefault();
    showNotification(
      "La taille totale des fichiers dépasse la limite autorisée de 20 MB.",
      "error",
    );
    return;
  }
});
