const config = useRuntimeConfig()

const HOST = config.public.apiUrl

export async function  getCountries() {
    //const URL = HOST + '/countries';

    const URL ='http://localhost:8000/countries';

    try {
        const response = await fetch(URL, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        });

        if (!response.ok) {
            throw new Error(`Error al obtenir països: ${response.statusText}`);
        }

        const countries = await response.json();
        return countries;
    } catch (error) {
        console.error('Error en la petició de països:', error);
        return [];
    }
}

export const register = async (userData) => {

    //const URL = HOST + '/auth/register';
    const URL ='http://localhost:8000/auth/register';


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

    //const URL = HOST + '/auth/login';
    const URL ='http://localhost:8000/auth/login';


    const response = await fetch(URL, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(userData),
    })

    console.log(response);

    const json = await response.json();
    // console.log(json);
    return json;

}

export async function logout() {

    //const URL = HOST + '/auth/logout';
    const URL ='http://localhost:8000/auth/logout';


    const response = await fetch(URL);

    const json = await response.json();

    console.log(json);

    return json;

}

export async function getCurrentUser(currentUserToken) {
    //const URL = HOST + '/currentUser';
    const URL ='http://localhost:8000/currentUser';


    try {
        const response = await fetch(URL, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${currentUserToken}`,
            },
        });

        if (response.ok) {
            const json = await response.json();
            return json;
        }

        if (response.status === 401) {
            console.error('Error 401: No autorizado');
            return {
                status: 'error',
                message: 'No autorizado, token no válido o expirado.',
            };
        }

        if (response.status === 405) {
            console.error('Error 405: Método no permitido');
            return {
                status: 'error',
                message: 'Método no permitido, por favor verifica la configuración del servidor.',
            };
        }

        console.error('Error al hacer la solicitud:', response.status);
        return {
            status: 'error',
            message: `Error inesperado: ${response.statusText}`,
        };

    } catch (error) {
        console.error('Error de red o con la solicitud:', error);
        return {
            status: 'error',
            message: "Agut un problema a l'hora de fer la sol·licitud. Intentau de nou.",
        };
    }
}

export async function changeInfoUser(currentUserToken, userData) {
    //const URL = `${HOST}/changeInfoProfile`;
    const URL ='http://localhost:8000/changeInfoProfile';


    try {
        const response = await fetch(URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${currentUserToken}`,
            },
            body: JSON.stringify({ ...userData }),
        });
        if (!response.ok) {
            throw new Error(`Error en la solicitud: ${response.statusText}`);
        }

        const json = await response.json();
        console.log('Respuesta del servidor:', json);
        return json
    } catch (error) {
        console.error('Error al cambiar la información del usuario:', error);
        throw error;
    }
}
