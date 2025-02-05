const config = useRuntimeConfig()

const HOST = config.public.apiUrl

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

    const response = await fetch(URL, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(userData),
    })

    console.log(response);

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

export async function getCurrentUser(currentUserToken) {
    const URL = HOST + '/currentUser';

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
    const URL = `${HOST}/changeInfoProfile`;

    try {
        const response = await fetch(URL, {
            method: 'PUT', // O 'PUT' dependiendo de lo que desees
            headers: {
                'Content-Type': 'application/json', // Especifica que el cuerpo es en formato JSON
                'Authorization': `Bearer ${currentUserToken}`
            },
            body: JSON.stringify(userData) // Convierte los datos a formato JSON
        });

        if (!response.ok) {
            throw new Error('Error en la solicitud');
        }

        const json = await response.json(); // Respuesta en formato JSON
        console.log('Respuesta del servidor:', json);

        return json; // Devuelve la respuesta para que se pueda manejar
    } catch (error) {
        console.error('Error al cambiar la información del usuario:', error);
        throw error; // Lanza el error para manejarlo más arriba
    }
}
