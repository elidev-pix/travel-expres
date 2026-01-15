import { Client, Storage, ID } from "appwrite";

export const client = new Client()
    .setEndpoint(import.meta.env.VITE_APPWRITE_ENDPOINT)
    .setProject(import.meta.env.VITE_APPWRITE_PROJECT_ID);

export const storage = new Storage(client);
export const id = ID;

// Tu peux ajouter le bucket ici pour centraliser
export const bucketId = import.meta.env.VITE_APPWRITE_BUCKET_ID;
