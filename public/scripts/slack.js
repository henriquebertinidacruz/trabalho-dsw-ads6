const axios = require('axios');

async function sendMessageToSlack(title, message) {
    try {
        const webhookUrl = 'https://hooks.slack.com/services/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';
        const messageFull = `\n*${title}*\n\n\`\`\`${message}\`\`\``;
        const payload = {
            text: messageFull
        };
        await axios.post(webhookUrl, payload);
    } catch (error) {
        throw error;
    }
}

sendMessageToSlack('Título da mensagem', 'Esta é uma mensagem de exemplo para o Slack.');
