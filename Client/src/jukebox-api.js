const axios     = require('axios').default;
const qs        = require('qs');
const server    = require('../config/jukebox-server');
/**
 * 
 * @param {"auth" | "users" | "songs" | "genres" | "lists"} collection 
 */
function call(collection)
{
    return `${server.address}/${server.version}/${collection}`;
}
export default
{
    // [Post]
    authenticate(userID, password)
    {
        return new Promise((resolve, reject) =>
        {
            // Make an api call
            axios(
                {
                    method: 'POST',
                    url: call('auth'),
                    responseType: 'json',
                    data: qs.stringify(
                        {
                            uid: userID,
                            password: password
                        }
                    )
                }
            ).then(res =>
            {
                // Create a buffer of our token
                const buffer = Buffer.from(res.data.token);
                // Encode our token buffer with base64 and resolve this promis
                resolve(buffer.toString('base64'));
            }).catch(err =>
            {
                reject(err);
            });
        });
    },

    // [Get]
    /**
     * Gets all the users from the server
     */
    getUsers()
    {
        return axios(
            {
                method: 'GET',
                url: call('users')
            }
        );
    }
}