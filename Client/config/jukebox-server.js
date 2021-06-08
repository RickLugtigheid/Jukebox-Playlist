module.exports =
{
    version: 'v1',
    address: 'http://localhost:3000',
    /**
     * 
     * @param {"auth" | "users" | "songs" | "genres" | "lists"} collection 
     */
    call(collection)
    {
        return `${this.address}/${this.version}/${collection}`;
    }
}