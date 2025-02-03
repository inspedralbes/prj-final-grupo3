const HOST = 'http://localhost:8000/api';
// const HOST = 'http://triplan.daw.inspedralbes.cat/laravel/public/api';


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

export async function getCurrentUser(currentTokenUser) {
    const URL = HOST + '/currentUser';

    try {
        const response = await fetch(URL, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${currentTokenUser}`,
            },
        });

        // Si la respuesta es exitosa (status 200), obtenemos el JSON
        if (response.ok) {
            const json = await response.json();
            return json;
        }

        // Si no es exitosa (código diferente a 200)
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

        // Para cualquier otro tipo de error, podemos capturarlo aquí
        console.error('Error al hacer la solicitud:', response.status);
        return {
            status: 'error',
            message: `Error inesperado: ${response.statusText}`,
        };

    } catch (error) {
        // Si hubo un problema en la red o en la solicitud, lo capturamos aquí
        console.error('Error de red o con la solicitud:', error);
        return {
            status: 'error',
            message: 'Hubo un problema al realizar la solicitud. Intenta nuevamente.',
        };
    }
}
