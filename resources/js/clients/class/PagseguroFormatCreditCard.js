

const formatCreditCardNumber = number =>
{
    return number.replace( /^\D+/g, '').replace(/\s/g, '');
}

const formatCreditCardExpire = (expire) =>
{
    return expire.split("/");
}

module.exports = { 
    formatCreditCardNumber,
    formatCreditCardExpire
}