const axios = require('axios');
const TonWeb = require('tonweb');
const { mnemonicToPrivateKey, mnemonicNew } = require('@ton/crypto');


// axios.post("https://api.telegram.org/bot7606646952:AAEKC9q8VRToKuzNNWSaRQ_nW9zKw9_cqSU/sendMessage", {
//     "chat_id": 2090667228,
//     "text": "hello"
// }).then(function(resp) {
//     console.log(resp.data)
// }).catch(function(err) {
//     console.log(err)
// })

async function createWallet() {
    const tonweb = new TonWeb();

    // 1. Генерируем seed-фразу (24 слова)
    const mnemonic = await mnemonicNew();
    // console.log("📜 Seed-фраза:", mnemonic.join(" "));

    // 2. Получаем приватный ключ
    const keyPair = await mnemonicToPrivateKey(mnemonic);
    const publicKey = keyPair.publicKey.toString("hex");
    const privateKey = keyPair.secretKey.toString("hex");

    // console.log("🔑 Public Key:", publicKey);
    // console.log("🔒 Private Key:", privateKey);

    // 3. Создаем кошелек V4R2 (он не меняет адрес после пополнения)
    const WalletClass = tonweb.wallet.all["v4R2"];
    const wallet = new WalletClass(tonweb.provider, {
        publicKey: keyPair.publicKey,
    });

    // 4. Получаем и выводим адрес (будет начинаться с EQ...)
    const address = await wallet.getAddress();

    // 5. Сохраняем данные в .env
    // const envData = `MNEMONIC="${mnemonic.join(" ")}"\nPRIVATE_KEY="${privateKey}"\nPUBLIC_KEY="${publicKey}"\nWALLET_ADDRESS="${address.toString(true, true, true)}"`;

    const result =  {
        "publicKey": publicKey,
        "privateKey": privateKey,
        "mnemonic": mnemonic.join(" "),
        "wallet": address.toString(true, true, true)
    }

    console.log(JSON.stringify(result))
}

return createWallet()
