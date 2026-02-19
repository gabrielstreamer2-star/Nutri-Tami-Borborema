const form = document.getElementById("chatForm");
const status = document.getElementById("status");

form.addEventListener("submit", async (e) => {
  e.preventDefault();
  const data = new FormData(form);

  try {
    const response = await fetch(form.action, { method: "POST", body: data });
    const result = await response.text();

    if (response.ok) {
      status.textContent = "Mensagem enviada com sucesso!";
      status.style.color = "#D4A017";
      form.reset();
    } else {
      status.textContent = "Erro ao enviar: " + result;
      status.style.color = "red";
    }
  } catch (err) {
    status.textContent = "Erro ao enviar a mensagem.";
    status.style.color = "red";
    console.error(err);
  }
});
