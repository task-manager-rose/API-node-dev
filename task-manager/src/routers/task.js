const express =  require('express')
const Task = require('../models/task')
const auth = require('../middleware/auth')
const router = new express.Router()

/* CREAR TAREA - CREATE TASK */
router.post('/task', auth,  (req, res)=>{
    /* crear la relacion */
    const task = new Task({
        ...req.body, user:req.user._id
    });

    task.save().then(() => {
        res.status(200).send(task)
    }).catch((e)=>{
        res.status(400).send(e)
    })
})
/* ACTUALIZAR TAREA - UPDATE TASK */
router.patch('/task/:id', auth,async (req, res)=>{
    const updates = Object.keys(req.body)
    const allowedUpdates = ['description', 'completed']
    const validOperation = updates.every((update)=> allowedUpdates.includes(update) )

    if (!validOperation){
        return res.status(400).send({error:'Invalid Update'})
    }

    try{
        const task = await Task.findOne({_id:req.params.id, user:req.user.id})
        
        if(!task){
            return res.status(400).send({error:'Task not Found!'})
        }

        updates.forEach((update)=> task[update] = req.body[update])
        await task.save()
        res.status(200).send(task)
    }catch(e){
        res.status(400).send(e)
    }
})

/* OBTENER TAREAS - GET TASKS */
router.get('/task', auth, async (req, res)=>{
    
    try{
        const tasks = await Task.find({user:req.user._id})
        if(!tasks){
            return res.status(404).send(tasks)    
        }
        res.send(tasks)
    }catch(e){
        res.status(500).send()
    }    
})

/* OBTENER TAREA - GET TASK */
router.get('/task/:id', auth, async (req, res)=>{
    
    const _id = req.params.id
    /*if (!_id.match(/^[0-9a-fA-F]{24}$/)) {
        return res.status(400).send()
      }*/

    try{
        // task = await Task.findById(_id)
        const task = await Task.findOne({_id, user:req.user._id})
        if (!task){
            return res.status(404).send()    
         }
         res.send(task)
    }catch(e){
        res.status(500).send()
    }
})
/* DELETE TASK - BORRAR TAREA */
router.delete('/task/:id', auth, async (req, res)=>{    
    try{
        const task = await Task.findOne({_id:req.params.id, user:req.user._id})

        if(!task){
            return res.status(404).send({error:'task not found'})
        }
        task.remove()
        res.send(task)
    }catch(e){
        res.status(500).send()
    }
})

module.exports = router