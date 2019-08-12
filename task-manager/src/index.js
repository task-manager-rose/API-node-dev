const express =  require('express')
require('./db/mongoose')
/* routes */
const userRouter = require('./routers/user')
const taskRouter = require('./routers/task')

/* expres conf */
const app = express()
const port = process.env.PORT || 3000

app.use(express.json())
/* ROUTES */
app.use(userRouter)
app.use(taskRouter)


app.listen(port, () => {
    console.log('Server running on port '+port)
})
/*
const Task = require('./models/task')
const User = require('./models/user')

const main = async () => {

    //const task = await Task.findById('5d4f94be2110d51db475454c')
    //await task.populate('user').execPopulate()
    //console.log(task)

    const user = await User.findById('5d4f9387fe26621f40ca624e')
    await user.populate('tasks').execPopulate()
    console.log(user.tasks)
}

main()*/