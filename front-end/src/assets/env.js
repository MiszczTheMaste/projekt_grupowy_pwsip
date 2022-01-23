const url = `http://94.250.201.248:8000`;

const env = {
    url,
    allProducts: `${url}/api/product/collection`,
    register : `${url}/api/auth/register`,
    login : `${url}/api/auth/token`,
    product : `${url}/api/product`,
    someItems : `${url}/api/product/collection`,
    session : `${url}/api/user/get-login`,
    buy_succeed : `${url}/api/order`,
    rate_items: `${url}/api/order/user`,
    create_item: `${url}/api/product`,
    create_reate : `${url}/api/rate`,
    change_password : `${url}/api/user/password-change`,
    rated_items : `${url}/api/product/rated`,
    set_stock : `${url}/api/stock/set`,
    delete_item  : `${url}/api/product`
}


module.exports = env;