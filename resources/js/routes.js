export default [
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/master/kurs-dollar', component: require('./components/master/Dollar.vue').default },
    { path: '/master/sub-ib', component: require('./components/master/Sub_ib.vue').default },
    { path: '/master/trader', component: require('./components/master/Trader.vue').default },
    { path: '/transaksi/upload', component: require('./components/transaksi/Upload.vue').default },
    { path: '/transaksi/rebate', component: require('./components/transaksi/Rebate.vue').default },
    { path: '/transaksi/komisi', component: require('./components/transaksi/Komisi.vue').default },
    { path: '/transaksi/trader', component: require('./components/transaksi/New_trader.vue').default },
    { path: '/profile', component: require('./components/Profile.vue').default },
    { path: '/developer', component: require('./components/Developer.vue').default },
    { path: '/users', component: require('./components/Users.vue').default },
    { path: '/products', component: require('./components/product/Products.vue').default },
    { path: '/product/tag', component: require('./components/product/Tag.vue').default },
    { path: '*', component: require('./components/NotFound.vue').default }
];
