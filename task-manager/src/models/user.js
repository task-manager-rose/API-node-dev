const mongoose =  require('mongoose')
const validator = require('validator')
const bcrypt = require('bcryptjs')
const jwt = require('jsonwebtoken')
const Task = require('./task')

const userSchema = new mongoose.Schema({
    name:{
        type: String,
        required:true,
        trim:true
    },
    password:{
        type: String,
        required:true,
        minlength:6,
        trim:true,
        validate(value){
            if(value.toLowerCase().includes('password')){
                throw new Error('Password cannot contain "password"');
            }
        }
    },
    email:{
        type:String,
        required:true,
        trim:true,
        unique:true,
        lowercase:true,
        validate(value){
            if(!validator.isEmail(value)){
                throw new Error('Email is invalid');
            }
        }
    },
    age:{
        type: Number,
        default:0,
        validate(value){
            if (value < 0){
                throw new Error('La edad no puede ser negativa')
            }
        }
    },
    tokens:[{
        token:{
            type:String,
            required:true
        }
    }]
})

userSchema.virtual('tasks',{ 
    ref: 'Task',
    localField: '_id',
    foreignField: 'user'
})

userSchema.methods.genToken = async function () {
    
    const user = this
    console.log(user)
    const token = jwt.sign({ _id: user._id.toString() }, 'thiskey')

    user.tokens = user.tokens.concat({ token })
    await user.save()

    return token
}

userSchema.methods.toJSON = function () {
    const user = this
    const userOb = user.toObject();

    delete userOb.password
    delete userOb.tokens

    return userOb
}
userSchema.statics.findByCredentials = async (email, password) => {
    const user = await User.findOne({ email })

    if (!user) {
        throw new Error('Unable to Login...')
    }

    const isMatch = await bcrypt.compare(password, user.password)

    if (!isMatch){
        throw new Error('Unable to Login...')
    }

    return user
}


/* hash password antes de guardar */
userSchema.pre('save', async function(next){
    const user = this

    if (user.isModified('password')) {
        user.password = await bcrypt.hash(user.password, 8)
    }

    next()
})

/* borrar tareas cuando el usuario se elimine a si mismo */
userSchema.pre('remove', async function(next){
    const user= this
    await Task.deleteMany({user:user._id})
    next()
})

const User = mongoose.model('User', userSchema)

module.exports = User