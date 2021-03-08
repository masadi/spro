export default [
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/master/sub-ib', component: require('./components/master/Sub_ib.vue').default },
    { path: '/master/trader', component: require('./components/master/Trader.vue').default },
    { path: '/profile', component: require('./components/Profile.vue').default },
    { path: '/developer', component: require('./components/Developer.vue').default },
    { path: '/users', component: require('./components/Users.vue').default },
    { path: '/products', component: require('./components/product/Products.vue').default },
    { path: '/product/tag', component: require('./components/product/Tag.vue').default },
    { path: '*', component: require('./components/NotFound.vue').default }
];
