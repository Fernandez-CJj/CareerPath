// Hide all templates on page load
window.addEventListener("DOMContentLoaded", function () {
  document.querySelector(".modern-resume").style.display = "none";
  document.querySelector(".professional-resume").style.display = "none";
  document.querySelector(".simple-resume").style.display = "none";
});
// Show only the Modern template
function showModernTemplate() {
  document.querySelector(".templates-container").style.display = "none";
  document.querySelector(".modern-resume").style.display = "block";
  document.querySelector(".professional-resume").style.display = "none";
  document.querySelector(".simple-resume").style.display = "none";
}

// Show only the Professional template
function showProfessionalTemplate() {
  document.querySelector(".templates-container").style.display = "none";
  document.querySelector(".modern-resume").style.display = "none";
  document.querySelector(".professional-resume").style.display = "block";
  document.querySelector(".simple-resume").style.display = "none";
}

// Show only the Simple template
function showSimpleTemplate() {
  document.querySelector(".templates-container").style.display = "none";
  document.querySelector(".modern-resume").style.display = "none";
  document.querySelector(".professional-resume").style.display = "none";
  document.querySelector(".simple-resume").style.display = "block";
}

function hideTemplates() {
  document.querySelector(".modern-resume").style.display = "none";
  document.querySelector(".professional-resume").style.display = "none";
  document.querySelector(".simple-resume").style.display = "none";
  document.querySelector(".templates-container").style.display = "block";
}

function downloadModernPDF() {
  const wrap = document.querySelector(".modern-resume");
  const section = document.querySelector(".modern");
  if (!wrap || !section || !window.html2pdf) return;

  // Toggle export class to apply CSS overrides (legal width, no margins)
  document.documentElement.classList.add("pdf-export");
  document.body.classList.add("pdf-export");

  const options = {
    margin: [0, 0, 0, 0],
    filename: "resume-modern-legal.pdf",
    image: { type: "jpeg", quality: 0.98 },
    html2canvas: {
      scale: 2,
      useCORS: true,
      scrollX: -window.scrollX,
      scrollY: 0,
    },
    jsPDF: { unit: "mm", format: "legal", orientation: "portrait" },
  };

  // Ensure the element is aligned to the top before capture
  try {
    section.scrollIntoView({ behavior: "auto", block: "start" });
  } catch (e) {}

  setTimeout(() => {
    window
      .html2pdf()
      .set(options)
      .from(section)
      .save()
      .finally(() => {
        document.documentElement.classList.remove("pdf-export");
        document.body.classList.remove("pdf-export");
      });
  }, 200);
}

function downloadProfessionalPDF() {
  const wrap = document.querySelector(".professional-resume");
  const section = document.querySelector(".professional");
  if (!wrap || !section || !window.html2pdf) return;

  document.documentElement.classList.add("pdf-export");
  document.body.classList.add("pdf-export");

  const options = {
    margin: [0, 0, 0, 0],
    filename: "resume-professional-legal.pdf",
    image: { type: "jpeg", quality: 0.98 },
    html2canvas: {
      scale: 2,
      useCORS: true,
      scrollX: -window.scrollX,
      scrollY: 0,
    },
    jsPDF: { unit: "mm", format: "legal", orientation: "portrait" },
  };

  try {
    section.scrollIntoView({ behavior: "auto", block: "start" });
  } catch (e) {}

  setTimeout(() => {
    window
      .html2pdf()
      .set(options)
      .from(section)
      .save()
      .finally(() => {
        document.documentElement.classList.remove("pdf-export");
        document.body.classList.remove("pdf-export");
      });
  }, 200);
}

function downloadSimplePDF() {
  const wrap = document.querySelector(".simple-resume");
  const section = document.querySelector(".simple");
  if (!wrap || !section || !window.html2pdf) return;

  document.documentElement.classList.add("pdf-export");
  document.body.classList.add("pdf-export");

  const options = {
    margin: [0, 0, 0, 0],
    filename: "resume-simple-legal.pdf",
    image: { type: "jpeg", quality: 0.98 },
    html2canvas: {
      scale: 2,
      useCORS: true,
      scrollX: -window.scrollX,
      scrollY: 0,
    },
    jsPDF: { unit: "mm", format: "legal", orientation: "portrait" },
  };

  try {
    section.scrollIntoView({ behavior: "auto", block: "start" });
  } catch (e) {}

  setTimeout(() => {
    window
      .html2pdf()
      .set(options)
      .from(section)
      .save()
      .finally(() => {
        document.documentElement.classList.remove("pdf-export");
        document.body.classList.remove("pdf-export");
      });
  }, 200);
}
