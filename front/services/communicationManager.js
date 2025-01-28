const HOST = 'http://localhost:8000/api';


export const register = async (userData) => {

    const URL = HOST + '/auth/register';

    console.log(userData);

    const response = await fetch(URL, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(userData),
    })

    const json = await response.json();
    // console.log(json);
    return json;

}
export const login = async (userData) => {

    const URL = HOST + '/auth/login';

    console.log(userData);

    const response = await fetch(URL, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(userData),
    })

    const json = await response.json();
    console.log(json);
    return json;

}

export async function logout() {

    const URL = HOST + '/auth/logout';

    const response = await fetch(URL);

    const json = await response.json();

    console.log(json);
    
    return json;

}