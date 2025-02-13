class UserController {
    
    static getHello(req, res) {
        res.send('El servidor esta funcionant!')
    }
}

module.exports = UserController