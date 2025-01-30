const HOST = 'http://localhost:8000/api';


const register = () => {

    const URL = HOST + '/register';

    const response = fetch(URL, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    
    const json = response.json();
    console.log(json);
    return json;
}