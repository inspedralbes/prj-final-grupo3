const config = useRuntimeConfig();

const HOST = config.public.apiUrl;
const HOSTNODE = config.public.apiUrlNode;

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

  const response = await fetch(URL, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(userData),
  });

  const json = await response.json();
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

  const json = await response.json();
  return json;
};

export async function logout() {
  const URL = `${HOST}/auth/logout`;

  const response = await fetch(URL);

  const json = await response.json();

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

    for (const [key, val] of formData.entries()) {
      if (val instanceof File) {

      } else {
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
    return travelHistory;
  } catch (error) {
    console.error(
      `Error al obtener el historial de viajes del usuario ${userId}:`,
      error
    );
    throw error;
  }
}

export async function deleteTravelTicket(userId, travelId, currentUserToken) {
  const URL = `${HOST}/trip-details/${userId}/${travelId}`;

  try {
    const response = await fetch(URL, {
      method: "DELETE",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${currentUserToken}`,
      },
    });

    if (!response.ok) {
      throw new Error(
        `Error al eliminar el ticket de viaje ${travelId} para el usuario ${userId}: ${response.statusText}`
      );
    }

    const travelHistory = await response.json();
    return travelHistory;
  } catch (error) {
    console.error(
      `Error al eliminar el ticket de viaje ${travelId} del usuario ${userId}:`,
      error
    );
    throw error;
  }
}

export async function postTravel(travelData, currentUserToken) {

  const response = await fetch(`${HOST}/travels`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      Authorization: `Bearer ${currentUserToken}`,
    },
    body: JSON.stringify(travelData),
  });

  const json = await response.json();

  return json;
}
export async function getTravelGemini(text) {
  if (!text) {
    throw new Error("Text parameter is required");
  }

  try {
    const response = await fetch(`${HOSTNODE}/api/gemini/response`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ text })
    });

    // if (!response.ok) {
    //   throw new Error(`Error in Gemini API request: ${response.statusText}`);
    // }

    const json = await response.json();

    if (!json) {
      throw new Error("Invalid response from Gemini API");
    }

    return json;
  } catch (error) {
    console.error("Error in getTravelGemini:", error);
    throw new Error(`Failed to get travel plan: ${error.message}`);
  }
}

export async function savePlaning(travelPlanData, currentUserToken, travelId) {

  travelPlanData.travel_id = travelId;

  const response = await fetch(`${HOST}/travel-plans`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      // Authorization: `Bearer ${currentUserToken}`,
    },
    body: JSON.stringify(travelPlanData),
  });

  const json = await response.json(); // return status code 

  return json;
}

export async function toggleFavorite(travelId, userId, currentUserToken) {
  const URL = `${HOST}/toggle-favorite`;

  try {
    const response = await fetch(URL, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        Authorization: `Bearer ${currentUserToken}`,
      },
      body: JSON.stringify({ travel_id: travelId }),
    });

    if (!response.ok) {
      const error = await response.json();
      throw new Error(error.message || 'Error al alternar favorito');
    }

    const result = await response.json();
    return result; // Devuelve el resultado de la API
  } catch (error) {
    console.error('Error al alternar favorito:', error);
    throw error; // Lanza el error para manejarlo en el componente
  }
}

export async function getUserFavorites(currentUserToken) {
  const URL = `${HOST}/user-favorites`;

  try {
    const response = await fetch(URL, {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json',
        Authorization: `Bearer ${currentUserToken}`,
      },
    });

    if (!response.ok) {
      const error = await response.json();
      throw new Error(error.message || 'Error al obtener los favoritos');
    }

    const favorites = await response.json();
    return favorites; // Devuelve la lista de favoritos
  } catch (error) {
    console.error('Error al obtener los favoritos:', error);
    throw error;
  }
}


export async function getHighlightedTrips() {
  const URL = `${HOST}/trips/highlighted`;

  try {
    const response = await fetch(URL, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
      },
    });

    if (!response.ok) {
      throw new Error(`Error al obtenir viatges destacats: ${response.statusText}`);
    }

    const trips = await response.json();
    return trips;
  } catch (error) {
    console.error("Error en la petició de viatges destacats:", error);
    return [];
  }
}


export async function getTripById(id) {
  const URL = `${HOST}/trips/${id}`

  try {
    const response = await fetch(URL, {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json',
      },
    })

    if (!response.ok) {
      throw new Error(`Error al obtenir viatge: ${response.statusText}`)
    }
    
    return await response.json()
  } catch (error) {
    console.error('Error en getTripById:', error)
    throw error
  }
}

// export async function fetchCommentsForTrip(tripId) {
//   const res = await fetch(`${HOST}/comments?tripId=${tripId}`, {
//     headers: {
//       'Content-Type': 'application/json',
//     },
//   });

//   if (!res.ok) {
//     const errorText = await res.text();
//     console.error('Error al carregar comentaris:', errorText);
//     throw new Error(`Error al carregar comentaris: ${res.statusText}`);
//   }

//   return await res.json();
// }

export async function fetchCommentsForTrip(tripId) {
  const res = await fetch(`${HOST}/comments?tripId=${tripId}`, {
    headers: {
      'Content-Type': 'application/json',
    },
  });

  if (!res.ok) {
    const errorText = await res.text();
    console.error('Error al carregar comentaris:', errorText);
    throw new Error(`Error al carregar comentaris: ${res.statusText}`);
  }

  return await res.json();
}
export async function postComment(tripId, text, token, rating) {
  const config = useRuntimeConfig()
  const HOST = config.public.apiUrl
  const URL = `${HOST}/comments`

  const res = await fetch(URL, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      Authorization: `Bearer ${token}`,
    },
    body: JSON.stringify({ tripId, comment: text, rating }),
  })

  const responseText = await res.clone().text()

  if (!res.ok) throw new Error(responseText)
  return JSON.parse(responseText)
}

export async function deleteComment(commentId, token) {
  const config = useRuntimeConfig()
  const HOST = config.public.apiUrl

  const res = await fetch(`${HOST}/comments/${commentId}`, {
    method: 'DELETE',
    headers: {
      Authorization: `Bearer ${token}`,
    },
  })

  if (!res.ok) {
    const err = await res.json()
    throw new Error(err?.error || 'Error eliminant el comentari.')
  }

  return await res.json()
}


export async function likeComment(commentId, token) {
  const config = useRuntimeConfig()
  const HOST = config.public.apiUrl

  const res = await fetch(`${HOST}/comment-like`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      Authorization: `Bearer ${token}`,
    },
    body: JSON.stringify({ comment_id: commentId }),
  })

  if (!res.ok) {
    const errorText = await res.text()
    throw new Error(`Error fent like: ${errorText}`)
  }

  return await res.json()
}




export async function sendTravelEmail(travelId, user, token) {
  const URL = `${HOST}/travel/${travelId}/send-email`;

  try {
    const response = await fetch(URL, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${token}`,
        Accept: "application/json",
      },
      body: JSON.stringify(user),
    });

    if (!response.ok) {
      const error = await response.json();
      throw new Error(error.message || "Error al enviar el correo.");
    }

    const data = await response.json();
    return data;
  } catch (error) {
    console.error("Error en sendTravelEmail:", error);
    throw error;
  }
}