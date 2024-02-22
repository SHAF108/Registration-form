const express = require('express');
const bodyParser = require('body-parser');
const dotenv = require('dotenv');
const mongodb = require('mongodb');
const mongoose = require('mongoose');
const path = require('path');
const { log } = require('console');


const app = express();
dotenv.config();

const port = process.env.PORT || 3000;


app.use('/assets', express.static(path.join(__dirname, 'assets')));
app.use('/cdn-cgi', express.static(path.join(__dirname, 'cdn-cgi')));
app.use('/checkout', express.static(path.join(__dirname, 'checkout')));
app.use('/css', express.static(path.join(__dirname, 'css')));
app.use('/fonts', express.static(path.join(__dirname, 'fonts')));
app.use('/img', express.static(path.join(__dirname, 'img')));
app.use('/js', express.static(path.join(__dirname, 'js')));
app.use('/razorpay-php', express.static(path.join(__dirname, 'razorpay-php')));
app.use('/about-us.html', express.static(path.join(__dirname, 'about-us.html')));

app.use('/blog.html', express.static(path.join(__dirname, 'blog.html')));
app.use('/careers.html', express.static(path.join(__dirname, 'careers.html')));
app.use('/config.php', express.static(path.join(__dirname, 'config.php')));
app.use('/contactus.html', express.static(path.join(__dirname, 'contactus.html')));
app.use('/faq_s.html', express.static(path.join(__dirname, 'faq_s.html')));
app.use('/index-2.html', express.static(path.join(__dirname, 'index-2.html')));
app.use('/pay.php', express.static(path.join(__dirname, 'pay.php')));
app.use('/paymentpage.html', express.static(path.join(__dirname, 'paymentpage.html')));
app.use('/phonepe.php', express.static(path.join(__dirname, 'phonepe.php')));
app.use('/Privacy-Policy.html', express.static(path.join(__dirname, 'Privacy-Policy.html')));
app.use('/redirect.php', express.static(path.join(__dirname, 'redirect.php'))); 

app.use('/return-policy.html', express.static(path.join(__dirname, 'return-policy.html')));
app.use('/services.html', express.static(path.join(__dirname, 'services.html')));
app.use('/style.css', express.static(path.join(__dirname, 'style.css')));
app.use('/terms-condition.html', express.static(path.join(__dirname, 'terms-condition.html')));
app.use('/value.php', express.static(path.join(__dirname, 'value.php')));
app.use('/verify.php', express.static(path.join(__dirname, 'veridy.php')));

const username = process.env.MONGODB_USERNAME;
const password = process.env.MONGODB_PASSWORD;

// MongoClient.connect(`mongodb+srv://${username}:${password}@registration.qsaa0r2.mongodb.net/registrationFormDB`, { useNewUrlParser: true })
mongoose.connect(`mongodb+srv://${username}:${password}@registration.qsaa0r2.mongodb.net/registrationFormDB`,{
    useNewUrlParser : true,
    useUnifiedTopology : true,
});

//Registration Schema
const registrationSchema = new mongoose.Schema({
    name: String,
    phoneNumber: Number,
    email: String
});

//Model of Registration schema
const Registration = mongoose.model("Registration", registrationSchema);

app.use(bodyParser.urlencoded({extended: true}));
app.use(bodyParser.json());

app.get('/', (req, res) =>{
    res.sendFile(__dirname + "/index.html");
})
app.post('/register', async (req, res) => {
    try {
        const {name, phoneNumber, email} = req.body;
        const existingUser = await Registration.findOne({email: email});
        //check for existing User
        if (!existingUser) {
            const registrationData = new Registration({
                name,
                phoneNumber,
                email
            })
            await registrationData.save();
            res.redirect("/success");
        } else {
            console.log("User already Exists");
            res.redirect("/error");
        }

    } catch (error) {
        console.log(error);
        res.redirect("/RegistrationError.html");
    }
})

app.get("/success", (req, res) =>{
    res.sendFile(__dirname + "/RegistrationSuccess.html")
})

app.get("/error",(req, res) =>{
    res.sendFile(__dirname + "/RegistrationError.html")
})

app.listen(port, () =>{
    console.log(`Server Running on PORT ${port}`);
})