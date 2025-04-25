import { CONFIG } from "../config/config.js";

export class PexelsService {
  static async getImageByQuery(query) {
    try {
      const response = await fetch(
        `https://api.pexels.com/v1/search?query=${encodeURIComponent(query)}&per_page=1`,
        {
          headers: {
            Authorization: CONFIG.PEXELS_API_KEY,
          },
        }
      );

      const data = await response.json();
      
      if (data.photos && data.photos.length > 0) {
        return data.photos[0].src.medium;
      }
      
      return null;
    } catch (error) {
      console.error("Error fetching image from Pexels:", error);
      return null;
    }
  }
}