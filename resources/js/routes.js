import Home from './components/Home'
import NotFound from "./components/NotFound";
import Login from "./components/Login";
import Register from "./components/Register";
import ImageUpload from "./components/ImageUpload";

export default{
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
        },
        {
            path: '/register',
            name: 'register',
            component: Register,
        },
        {
            path: '/image/upload',
            name: 'imageUpload',
            component: ImageUpload,
        },
        {
            path: "*",
            component: NotFound
        }

    ]
}
