const questionsArray = [
    {
        question: "Welke spier train je vooral met de bench press?",
        options: ["Borstspieren", "Biceps", "Triceps"],
        answer: "Borstspieren"
    },
    {
        //options in de array omdat er meerdere opties zijn en een ARRAY is precies bedoel voor een lijst met dingen.
        question: "Welke oefening is het beste voor het trainen van de rugspieren?",
        options: ["Deadlift", "Squat", "Lunges"],
        answer: "Deadlift"
    },
    {
        question: "Wat is de aanbevolen rusttijd tussen sets voor spiergroei?",
        options: ["30 seconden", "60-90 seconden", "3 minuten"],
        answer: "60-90 seconden"
    },
    {
        question: "Welke macronutriënt is het belangrijkste voor spierherstel?",
        options: ["Koolhydraten", "Eiwitten", "Vetten"],
        answer: "Eiwitten"
    },
    {
        question: "Wat is de juiste techniek voor een squat?",
        options: ["Houd je rug recht en zak door je knieën", "Leun naar voren en houd je knieën recht", "Houd je voeten dicht bij elkaar"],
        answer: "Houd je rug recht en zak door je knieën"
    },
    {
        question: "Welke oefening is het meest effectief voor het trainen van de buikspieren?",
        options: ["Crunches", "Plank", "Leg Raises"],
        answer: "Plank"
    },
    {
        question: "Wat is de aanbevolen dagelijkse hoeveelheid eiwitten voor spieropbouw?",
        options: ["0.8 gram per kilogram lichaamsgewicht", "1.2-2.0 gram per kilogram lichaamsgewicht", "3.0 gram per kilogram lichaamsgewicht"],
        answer: "1.2-2.0 gram per kilogram lichaamsgewicht"
    },
    {
        question: "Welke oefening is het beste voor het trainen van de schouders?",
        options: ["Shoulder Press", "Bicep Curl", "Tricep Dip"],
        answer: "Shoulder Press"
    },
    {
        question: "Wat is de juiste ademhalingstechniek tijdens het tillen van gewichten?",
        options: ["Inademen tijdens het tillen, uitademen tijdens het laten zakken", "Uitademen tijdens het tillen, inademen tijdens het laten zakken", "Adem niet tijdens het tillen"],
        answer: "Uitademen tijdens het tillen, inademen tijdens het laten zakken"
    },
    {
        question: "Welke oefening is het meest effectief voor het trainen van de benen?",
        options: ["Lunges", "Leg Press", "Squats"],
        answer: "Squats"
    }
]

const button1 = document.querySelector('#btn1');
const button2 = document.querySelector('#btn2');
const button3 = document.querySelector('#btn3');
const questionsText = document.querySelector('#questionText');


let currentQuestionIndex = 0;
let score = 0;


function loadQuestion() {
    // om de vraagtext te laden moet hij eerst weten welke questionindex het is daarom is het questionsArray[currentQuestionIndex].question
    questionsText.textContent = questionsArray[currentQuestionIndex].question
    button1.textContent = questionsArray[currentQuestionIndex].options[0];
    button2.textContent = questionsArray[currentQuestionIndex].options[1];
    button3.textContent = questionsArray[currentQuestionIndex].options[2];
}


function checkAnswer(selectedOption) {
    if (selectedOption === questionsArray[currentQuestionIndex].answer) {
        currentQuestionIndex++;
        score++;
    } else {
        currentQuestionIndex++;
    }
}

button1.addEventListener('click', function () {
    checkAnswer(questionsArray[currentQuestionIndex].options[0]);
    if (currentQuestionIndex >= questionsArray.length) {
        questionsText.textContent = "Je hebt " + score + " van de " + questionsArray.length + " vragen goed beantwoord!";
    } else {
        loadQuestion();
    }
});
button2.addEventListener('click', function () {
    checkAnswer(questionsArray[currentQuestionIndex].options[1]);
    if (currentQuestionIndex >= questionsArray.length) {
        questionsText.textContent = "Je hebt " + score + " van de " + questionsArray.length + " vragen goed beantwoord!";
    } else {
        loadQuestion();
    }
});
button3.addEventListener('click', function () {
    checkAnswer(questionsArray[currentQuestionIndex].options[2]);
    if (currentQuestionIndex >= questionsArray.length) {
        questionsText.textContent = "Je hebt " + score + " van de " + questionsArray.length + " vragen goed beantwoord!";
    } else {
        loadQuestion();
    }
});


loadQuestion();