export default class ApiRequest {

    _defaults = {
        get defaults(){
            let result = {
                cache: 'no-cache',
                headers: {
                    'Content-Type': 'application/json',
                }
            };

            const token = localStorage.getItem('access_token');
            if(token){
                result.headers.Authorization = 'Bearer ' + token;
            }

            return result;
        },

        get postSettings() {
            return {
                ...JSON.parse(JSON.stringify(this.defaults)),
                method: 'POST',
            };
        },

        get deleteSettings() {
            return {
                ...JSON.parse(JSON.stringify(this.defaults)),
                method: 'DELETE',
            };
        },


        get getSettings(){
            return {
                ...JSON.parse(JSON.stringify(this.defaults)),
            };
        },
    };

    _prepareSettings(sourceSettings, params = {}, data = null){
        let settings = {
            ...JSON.parse(JSON.stringify(sourceSettings)),
            params
        };

        //make available auto Content-Type (for example, for FormData with files sending)
        if(!settings.headers['Content-Type']){
            delete settings.headers['Content-Type'];
        }

        //prepare JSON for json requests
        if(data){
            if(settings.headers['Content-Type'] === 'application/json'){
                settings.body = JSON.stringify(data);
            }else{
                settings.body = data;
            }
        }

        return settings;
    }

    async _processResponse(response){
        if(!response.ok){
            throw response;
        }

        switch (response.headers.get('Content-Type')) {
            case 'application/json':
            case 'application/json; charset=UTF-8':
                return await response.json();

            default:
                return response;
        }
    }

    async get(url, params = {}) {
        let settings = this._prepareSettings(this._defaults.getSettings, params);
        let response = await fetch(url, settings);
        return await this._processResponse(response);
    }

    async post(url, data = {}, params = {}) {
        let settings = this._prepareSettings(this._defaults.postSettings, params, data);
        let response = await fetch(url, settings);
        return await this._processResponse(response);
    }

    async delete(url, params = {}) {
        let settings = this._prepareSettings(this._defaults.deleteSettings, params);
        let response = await fetch(url, settings);

        if(!response.ok && response.status === 449){
            let message = await response.text();
            if(confirm(message))
                await this.delete(url + '?force=true');
            return response;
        }

        return await this._processResponse(response);
    }

}