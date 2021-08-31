const axios     = require('axios').default;
const qs        = require('qs');
const server    = require('../config/jukebox-server');
/**
 * 
 * @param {"auth" | "users" | "songs" | "genres" | "playlists"} collection 
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
                resolve({token: buffer.toString('base64')});
            }).catch(err =>
            {
                reject(err);
            });
        });
    },
    tokenExpired(token)
    {
        return new Promise(resolve =>
        {
            axios(
                {
                    method: 'GET',
                    url: call('auth'),
                    headers: 
                    {
                        Authorization: token
                    }
                }
            ).then(() => resolve(true)).catch(() => resolve(false));
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
    },
    getGenres(token, id = '')
    {
        return axios(
            {
                method: 'GET',
                url: call('genres') + '/' + id,
                headers: 
                {
                    Authorization: token
                }
            }
        );
    },
    getGenreSongs(token, id = '')
    {
        return axios(
            {
                method: 'GET',
                url: call('genres') + '/' + id + '/songs',
                headers: 
                {
                    Authorization: token
                }
            }
        );
    },
    getSongs(token, id = '')
    {
        return axios(
            {
                method: 'GET',
                url: call('songs') + '/' + id,
                headers: 
                {
                    Authorization: token
                }
            }
        );
    },
    getPlaylists(token, id = '')
    {
        return axios(
            {
                method: 'GET',
                url: call('playlists') + '/' + id,
                headers: 
                {
                    Authorization: token
                }
            }
        );
    },
    getPlaylistSongs(token, id)
    {
        return axios(
            {
                method: 'GET',
                url: call('playlists') + '/' + id + '/songs',
                headers: 
                {
                    Authorization: token
                }
            }
        );
    },
    /**
     * 
     * @param {string} token 
     * @param {string} name 
     * @param {boolean} is_public 
     * @param {string} userID 
     */
    createPlaylist(token, name, is_public, userID)
    {
        return axios(
            {
                method: 'POST',
                url: `${call('playlists')}`,
                headers: 
                {
                    Authorization: token
                },
                data: qs.stringify({
                    name: name,
                    is_public: is_public ? '1' : '0',
                    userID: userID
                })
            }
        );
    },
    createUser(name, password)
    {
        return axios(
            {
                method: 'POST',
                url: `${call('users')}`,
                data: qs.stringify({
                    username: name,
                    password: password
                })
            }
        );
    },
    addPlaylistSong(token, playlistID, songID)
    {
        return axios(
            {
                method: 'POST',
                url: call('playlists') + '/' + playlistID + '/song/' + songID,
                headers: 
                {
                    Authorization: token
                }
            }
        );
    },
    removePlaylistSong(token, playlistID, songID)
    {
        return axios(
            {
                method: 'DELETE',
                url: call('playlists') + '/' + playlistID + '/song/' + songID,
                headers: 
                {
                    Authorization: token
                }
            }
        );
    }
}