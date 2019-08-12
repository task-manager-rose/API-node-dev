const express =  require('express')
const User = require('../models/user')
const router = new express.Router()
const auth = require('../middleware/auth')

/* CREAR USUARIO - CREATE USER */
router.post('/users', async (req, res)=>{
    
    const user = new User(req.body);
    
    try{
        await user.save()
        const token = await user.genToken()
        res.status(201).send({ user , token })
    }catch(e){
        res.status(400).send()
    }
})

/* LOGIN USUARIO - LOGIN USER */
router.post('/users/login', async (req, res)=>{
    try{
        const user = await User.findByCredentials(req.body.email, req.body.password)
        const token = await user.genToken()
        res.send({ user, token })
    }catch(e){
        res.status(400).send()
    }
})
/* LOGOUT USUARIO - LOGOUT USER */
router.post('/users/logout', auth, async (req, res)=>{

    try{
        req.user.tokens = req.user.tokens.filter((token)=>{
            return token.token !== req.token
        })
        await req.user.save()
        res.send()
    }catch(e){
        res.status(500).send()
    }
})
/* Logout todos los tokens */
router.post('/users/logoutAll', auth, async (req, res)=>{

    try{
        req.user.tokens = []
        await req.user.save()
        res.send()
    }catch(e){
        res.status(500).send()
    }
})

/* OBTENER PERFIL - GET PROFILE */
router.get('/users/profile', auth, async ( req, res ) => {
    res.send(req.user)
})

/* OBTENER USUARIO - GET USER - NO DEBERIAMOS UTILIZAR ESTA FUNCION POR SEGURIDAD
router.get('/users/:id', async ( req, res ) => {
    const _id = req.params.id
    if (!_id.match(/^[0-9a-fA-F]{24}$/)) {
        return res.status(400).send()
    }
    
    try{
        const user = await User.findById(_id)
        if(!user){ return res.status(404).send() }
        res.send(user)
    }catch(e){
        res.status(500).send(e)
    }
})
*/
/* ACTUALIZAR USUARIO - UPDATE USER */
router.patch('/users/profile', auth,  async (req, res)=>{
    const updates = Object.keys(req.body)
    const allowedUpdates = ['name', 'email', 'password','age']
    const validOperation = updates.every((update)=> allowedUpdates.includes(update) )

    if (!validOperation){
        return res.status(400).send({error:'Invalid Update'})
    }

    try{

        updates.forEach((update) => req.user[update] = req.body[update])

        await req.user.save()

        res.send(req.user)
    }catch(e){
        res.status(400).send()
    }
})

/* BORRAR USUARIO - DELETE USER -- ONLY SELF DELETE */
router.delete('/users/profile', auth, async (req, res)=>{    
    try{
        //const user = await User.findByIdAndDelete(req.user._id)
        await req.user.remove()
        res.send(user)
    }catch(e){
        res.status(500).send()
    }
})

module.exports = router