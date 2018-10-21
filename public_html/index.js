const express = require('express');
const app = express();

app.use(express.json());

app.post('/notifications/:action', (req, res) => {


    let responseBody = {
        action: {
            actionToPerform: 'Continue',
            digitCapture: {
                digitConfiguration: {
                    maxDigits: 10,
                    minDigits: 3,
                    endChar: "#"

                },
                playingConfiguration: {
                    playFileLocation: "https://junctionx-nbsp.s3.amazonaws.com/pollyfb7696c7b5f651d15b17dd062d710814.wav",
                    messageFormat: 'Audio',
                    mediaType: 'audio/wav',
                    interruptMedia: 'true'
                }
            },
            playAndCollectInteractionSubscription: {
                callbackReference: {
                    notifyURL: "https://www.example.com/notifyURL"
                }
            }
        }
    };

    console.log(responseBody);


    res.send(responseBody);
});


app.listen(8080);
