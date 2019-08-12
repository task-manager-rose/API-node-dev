const path = require('path')
const express = require('express')
const hbs = require('hbs')
const bodyParser = require('body-parser')
const Login = require('./utils/login')
const cookieParser = require('cookie-parser')
const session = require('express-session')

const app = express()
const port = process.env.PORT || 3000

// Define paths for Express config
const publicDirectoryPath = path.join(__dirname, '../public')
const viewsPath = path.join(__dirname, '../templates/views')
const partialsPath = path.join(__dirname, '../templates/partials')

// Setup handlebars engine and views location
app.set('view engine', 'hbs')
app.set('views', viewsPath)
hbs.registerPartials(partialsPath)
app.use(bodyParser.urlencoded({ extended: false }))
app.use(cookieParser());
app.use(session({secret:"5mdgroup", cookie:{maxAge:2000}}));
// Setup static directory to serve
app.use(express.static(publicDirectoryPath))

app.post('/login', function (req, res) {    
    Login(req.body, (e, user)=>{
        if (e){
            req.session.message = 'Unable to login'
            return res.redirect('/')            
        }
        req.session.token = user.token
        req.session.user = user.user
        res.cookie('sessionToken', user.token, { expire: 1500 + Date.now()});
        res.cookie('userData', user.user, { expire: 1500 + Date.now()});
        res.redirect('/taskInterface')
    })
})

app.get('/logOut', function(req, res){
    res.clearCookie("sessionToken");
    res.clearCookie("userData");
    req.session.destroy()
    res.redirect('/')
})

app.get('', (req, res) => {
    console.log(req.cookies.sessionToken)
    data = { title: 'task', name: 'Nestor Castellano'}
    if(req.session.message){
        data.message = req.session.message
    }
    if(req.cookies.sessionToken){
        return res.redirect('/taskInterface')
    }
    console.log(data)
    res.render('index', data)
   
})  
app.get('/taskInterface', (req, res) => {
    if(!req.cookies.sessionToken){
        return res.redirect('logOut')
    }
    res.render('taskIndex', {
        title: 'Tasks',
        user: req.cookies.userData
    })
})

app.get('/signUp', (req, res) => {
    res.render('signUp', {
        title: 'About Me',
        name: 'Nestor Castellano'
    })
})

app.get('*', (req, res) => {
    res.render('404', {
        title: '404',
        name: 'Nestor Castellano',
        errorMessage: 'Page not found.'
    })
})

app.listen(port, () => {
    console.log('Server is up on port ' + port)
})
