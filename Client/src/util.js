import Vue from './main';
export default
{
    /**
     * Converts a string to a hex color
     * @param {string} string input string
     * @returns Color in hex
     */
    stringToColor(string) 
    {
        var hash = 0;
        for (var i = 0; i < string.length; i++) {
          hash = string.charCodeAt(i) + ((hash << 5) - hash);
        }
        var colour = '#';
        for (i = 0; i < 3; i++) {
          var value = (hash >> (i * 8)) & 0xFF;
          colour += ('00' + value.toString(16)).substr(-2);
        }
        return colour;
    },
    /**
     * 
     * @param {string} hexColor Hex to add alpha to
     * @param {number} alpha Ammout of alpha to add [0 to 1]
     * @returns Hex alpha
     */
    hexAddAlpha(hexColor, alpha) 
    {
        // Generate the opacity
        let opacity = Math.round(Math.min(Math.max(alpha || 1, 0), 1) * 255);
        // Add the opacity to the hex color
        return hexColor + opacity.toString(16).toUpperCase();
    },
    /**
     * Makes a hex color darker or lighter
     * @param {string} color Hex color
     * @param {*} light 
     * @returns 
     */
    hexAddShade(color, light) {    
        var r = parseInt(color.substr(1, 2), 16);
        var g = parseInt(color.substr(3, 2), 16);
        var b = parseInt(color.substr(5, 2), 16);
    
        if (light < 0) {
            r = (1 + light) * r;
            g = (1 + light) * g;
            b = (1 + light) * b;
        } else {
            r = (1 - light) * r + light * 255;
            g = (1 - light) * g + light * 255;
            b = (1 - light) * b + light * 255;
        }

        // Back to hex
        const rgbN = (1 << 24) | (r << 16) | (g << 8) | b
        const hex = rgbN.toString(16).slice(1)
        const alpha = (1 * 255)
          .toString(16)
          .padStart(2, '0')
          .slice(0, 2)
        return `#${hex}${alpha}`
    },
    /**
     * Handles the errors that the api may give back
     * @param {AxiosError} err 
     */
    handleApiError(err)
    {
        switch(err.response.status)
        {
            // When we get any of these we need to create a new session
            case 498:
            case 503:
                Vue.$cookies.remove('token');
                Vue.$router.push({ path: '/login' });
                break;
            default:
                console.log(err.response)
            break;
        }
    }
}
import server  from '../src/jukebox-api'
import exports from './util'
/**
 * @interface
 */
class IPlaylist
{
    addSong(id) { throw Error("Not implemented " + id); }
    getSongs() { throw Error("Not implemented "); }
    getTotalDuration()
    {
        let duration = 0;
        return this.getSongs().then(res => 
        {
            res.data.data.forEach(song => {
                duration += parseInt(song.attributes.duration);
            });
            return duration;
        });
    }
    removeSong(id) { throw Error("Not implemented " + id); }
    destroy() { throw Error("Not implemented "); }
}
export class SessionPlaylist extends IPlaylist
{
    /**
     * Stores all sessions
     * @type {Array<SessionPlaylist>}
     */
    static sessions = [];

    /**
     * The index of the array where our session is stored
     */
    id;

    /**
     * A song object from the database
     * @type {{"data":[{"type":"song", "id": number, "attributes":{ "name": string, "artist": string, "genreID": number }}]}}
     */
    songs = { data: [] };

    constructor(name)
    {
        super();
        this.name = name;
        // Add this to the session list
        this.id = SessionPlaylist.sessions.length;
        SessionPlaylist.sessions.push(this);
    }
    getSongs() { return new Promise(resolve => resolve({ data: this.songs })); }

    addSong(id)
    {
        return server.getSongs(Vue.$cookies.get('token'), id).then(res =>
        {
            this.songs.data.push(res.data.data[0]);
        });
    }
    removeSong(id)
    {
        this.songs.data.filter(song => 
        {
            return song.id != id;
        })
    }
    /**
     * Destroys this session
     */
    destroy()
    {
        // Remove our session from the array
        SessionPlaylist.sessions.splice(this.id, 1);
    }

    static getSession(id) { return this.sessions[id]; }
}
export class ApiPlaylist extends IPlaylist
{
    #token;
    constructor(token, id, name = '')
    {
        super();
        this.#token = token;
        this.id = id;
        this.name = name;
    }
    getSongs()
    {
        return server.getPlaylistSongs(this.#token, this.id).catch(exports.handleApiError);
    }
    addSong(id)
    {
        console.warn(id);
        return server.addPlaylistSong(this.#token, this.id, id).catch(exports.handleApiError);
    }
    removeSong(id)
    {
        server.removePlaylistSong(this.#token, this.id, id).catch(exports.handleApiError);
    }
    // TODO: 
    /*destroy()
    {
        server.removePlaylist();
    }*/
}