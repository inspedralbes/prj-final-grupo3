const config = useRuntimeConfig();

const HOST = config.public.apiUrl;

export async function getTypes() {
  const URL = `${HOST}/types`;

  try {
    const response = await fetch(URL, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
      },
    });

    if (!response.ok) {
      throw new Error(`Error al obtenir tipus: ${response.statusText}`);
    }

    const types = await response.json();
    return types;
  } catch (error) {
    console.error("Error en la petició de tipus:", error);
    return [];
  }
}
export async function getMovilities() {
  const URL = `${HOST}/movilities`;

  try {
    const response = await fetch(URL, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
      },
    });

    if (!response.ok) {
      throw new Error(`Error al obtenir movilitats: ${response.statusText}`);
    }

    const movilities = await response.json();
    return movilities;
  } catch (error) {
    console.error("Error en la petició de movilitats:", error);
    return [];
  }
}

export async function getCountries() {
  const URL = `${HOST}/countries`;

  try {
    const response = await fetch(URL, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
      },
    });

    if (!response.ok) {
      throw new Error(`Error al obtenir països: ${response.statusText}`);
    }

    const countries = await response.json();
    return countries;
  } catch (error) {
    console.error("Error en la petició de països:", error);
    return [];
  }
}

export const register = async (userData) => {
  const URL = `${HOST}/auth/register`;

  console.log(userData);

  const response = await fetch(URL, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(userData),
  });

  const json = await response.json();
  // console.log(json);
  return json;
};

export const login = async (userData) => {
  const URL = `${HOST}/auth/login`;

  const response = await fetch(URL, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(userData),
  });

  console.log(response);

  const json = await response.json();
  return json;
};

export async function logout() {
  const URL = `${HOST}/auth/logout`;

  const response = await fetch(URL);

  const json = await response.json();

  console.log(json);

  return json;
}

export async function getCurrentUser(currentUserToken) {
  const URL = `${HOST}/currentUser`;

  try {
    const response = await fetch(URL, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${currentUserToken}`,
      },
    });

    if (response.ok) {
      const json = await response.json();
      return json.user;
    }

    if (response.status === 401) {
      console.error("Error 401: No autorizado");
      return {
        status: "error",
        message: "No autorizado, token no válido o expirado.",
      };
    }

    if (response.status === 405) {
      console.error("Error 405: Método no permitido");
      return {
        status: "error",
        message:
          "Método no permitido, por favor verifica la configuración del servidor.",
      };
    }

    console.error("Error al hacer la solicitud:", response.status);
    return {
      status: "error",
      message: `Error inesperado: ${response.statusText}`,
    };
  } catch (error) {
    console.error("Error de red o con la solicitud:", error);
    return {
      status: "error",
      message:
        "Agut un problema a l'hora de fer la sol·licitud. Intentau de nou.",
    };
  }
}

export async function changeInfoUser(currentUserToken, userData) {
  const URL = `${HOST}/changeInfoProfile`;

  try {
    const formData = new FormData();

    formData.append("_method", "PATCH"); // Laravel PATCH workaround

    for (const key in userData) {
      if (["avatarFile", "avatar"].includes(key)) continue;
      formData.append(key, userData[key]);
    }

    if (userData.avatarFile?.raw) {
      formData.append("avatar", userData.avatarFile.raw);
    }

    console.log("Dades que senvien:");

    for (const [key, val] of formData.entries()) {
      if (val instanceof File) {
        console.log(
          `${key}: [Fitxer] nom=${val.name}, tipus=${val.type}, mida=${val.size}B`
        );
      } else {
        console.log(`${key}:`, val);
      }
    }

    const response = await fetch(URL, {
      method: "POST",
      headers: {
        Authorization: `Bearer ${currentUserToken}`,
      },
      body: formData,
    });

    if (!response.ok) {
      const err = await response.json();
      throw new Error(JSON.stringify(err?.error || err));
    }

    return await response.json();
  } catch (error) {
    console.error("Error al canviar la informació del perfil:", error);
    return {
      status: "error",
      message: error.message || "Error al canviar la informació del perfil.",
    };
  }
}

export async function getUserTravelHistory(userId, currentUserToken) {
  const URL = `${HOST}/trip-details/${userId}`;

  try {
    const response = await fetch(URL, {
      method: "GET",
      credentials: "include",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${currentUserToken}`,
      },
    });

    if (!response.ok) {
      throw new Error(
        `Error al obtener el historial de viajes para el usuario ${userId}: ${response.statusText}`
      );
    }

    const travelHistory = await response.json();
    console.log("Respuesta del servidor:", travelHistory);
    return travelHistory;
  } catch (error) {
    console.error(
      `Error al obtener el historial de viajes del usuario ${userId}:`,
      error
    );
    throw error;
  }
}

export async function postTravel(travelData, currentUserToken) {
  console.log(travelData);

  const response = await fetch(`${HOST}/travels`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      Authorization: `Bearer ${currentUserToken}`,
    },
    body: JSON.stringify(travelData),
  });

  const json = await response.json();
  console.log("Respuesta desde el communication manager", json);

  return json;
}
