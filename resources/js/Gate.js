export default class Gate {

    constructor(user) {
        this.user = user;
    }

    isAdmin() {
        console.log(this.user);
        return this.user.type === 'admin';
    }

    isUser() {
        return this.user.type === 'user';
    }

    isAdminOrUser() {
        if (this.user.type === 'user' || this.user.type === 'admin') {
            return true;
        }
    }
}