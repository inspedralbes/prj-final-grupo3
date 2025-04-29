// mock-ai-responses.js
export const gemini = {
  responses: {
    // Basic greetings and common questions
    "hello": {
      text: "Hello! How can I assist you today?",
      delay: 500,
      isAI: true
    },
    "hi": {
      text: "Hi there! What can I help you with?",
      delay: 500,
      isAI: true
    },
    "how are you": {
      text: "I'm functioning well, thank you for asking! How can I help you?",
      delay: 700,
      isAI: true
    },

    // Questions about the service/product
    "what can you do": {
      text: "I can answer questions, provide information, help you navigate our services, and assist with common tasks. Feel free to ask me anything!",
      delay: 1200,
      isAI: true
    },
    "help": {
      text: "I'm here to help! You can ask me questions about our products, services, or how to use different features. What do you need assistance with?",
      delay: 800,
      isAI: true
    },

    // Technical questions
    "how does this work": {
      text: "This chat interface allows you to communicate with an AI assistant. Just type your questions or requests, and I'll respond with helpful information.",
      delay: 1000,
      isAI: true
    },

    // Fallback for unrecognized inputs
    "default": {
      text: "I'm not sure I understand. Could you rephrase your question or provide more details?",
      delay: 900,
      isAI: true
    }
  },

  // Function to get AI response based on user input
  getResponse(userInput) {
    const input = userInput.toLowerCase().trim();

    console.log(input);


    // Check for exact matches first
    if (this.responses[input]) {
      return this.responses[input];
    }

    // Check for partial matches
    for (const key in this.responses) {
      if (input.includes(key) && key !== "default") {
        return this.responses[key];
      }
    }

    // Check for question types
    if (input.includes("?")) {
      if (input.startsWith("can you") || input.startsWith("could you")) {
        return {
          text: "Yes, I can help with that. What specifically would you like to know?",
          delay: 800,
          isAI: true
        };
      }
      if (input.startsWith("why") || input.startsWith("how") || input.startsWith("what")) {
        return {
          text: "That's an interesting question. To give you the best answer, could you provide a bit more context?",
          delay: 1100,
          isAI: true
        };
      }
    }

    // Use default response if no matches
    return this.responses.default;
  }
}

export default gemini;