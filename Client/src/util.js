import Vue from 'vue';
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
     * 
     * @param {AxiosError} err 
     */
    handleApiError(err)
    {
        switch(err.response.status)
        {
            case 498:
                Vue.$cookies.remove('token');
                Vue.$router.push({ path: '/login' });
                console.warn('Token expired');
                break;
            default:
                console.log(err.response)
            break;
        }
    }
}