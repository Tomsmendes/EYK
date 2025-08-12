alerrt(88)
// const questions = [
//     {
//         question: "O que significa EYK?",
//         options: ["Ensino e Conhecimento", "Ekola ya Kelela", "Estudo e Juventude", "Educação e Cultura"],
//         correctAnswer: "Ekola ya Kelela"
//     },
//     {
//         question: "Qual é a unidade de medida da tensão elétrica?",
//         options: ["Ohm", "Watt", "Ampère", "Volt"],
//         correctAnswer: "Volt"
//     },
//     {
//         question: "Qual animal é o mascote da plataforma EYK?",
//         options: ["Urso", "Pinguim", "Cachorro", "Gato"],
//         correctAnswer: "Pinguim"
//     }
// ];

// let currentQuestion = 0;
// let score = 0;

// function showQuestion() {
//     const q = questions[currentQuestion];
//     document.getElementById("quiz-question").textContent = q.question;
//     const optionsDiv = document.getElementById("quiz-options");
//     optionsDiv.innerHTML = '';

//     q.options.forEach(option => {
//         const btn = document.createElement("button");
//         btn.textContent = option;
//         btn.style.padding = "10px";
//         btn.style.borderRadius = "6px";
//         btn.style.border = "1px solid #ccc";
//         btn.style.cursor = "pointer";
//         btn.style.backgroundColor = "#f0f0f0";
//         btn.style.color = "#000";
//         btn.onclick = () => checkAnswer(option);
//         optionsDiv.appendChild(btn);
//     });

//     document.getElementById("quiz-feedback").textContent = '';
// }

// function checkAnswer(selected) {
//     const correct = questions[currentQuestion].correctAnswer;
//     const feedback = document.getElementById("quiz-feedback");
//     if (selected === correct) {
//         score++;
//         feedback.textContent = "✅ Correto!";
//         feedback.style.color = "green";
//     } else {
//         feedback.textContent = "❌ Errado! Resposta certa: " + correct;
//         feedback.style.color = "red";
//     }
//     document.getElementById("quiz-score").textContent = `Pontuação: ${score} / ${questions.length}`;
// }

// function nextQuestion() {
//     if (currentQuestion < questions.length - 1) {
//         currentQuestion++;
//         showQuestion();
//     } else {
//         document.getElementById("quiz-question").textContent = "🏁 Fim do quiz!";
//         document.getElementById("quiz-options").innerHTML = '';
//         document.getElementById("quiz-feedback").textContent = '';
//     }
// }

// document.addEventListener("DOMContentLoaded", showQuestion);
