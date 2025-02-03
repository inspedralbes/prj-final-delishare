<template>
    <div class="profile">
        <!-- Encabezado del perfil -->
        <div class="profile-header">
            <img :src="user.image" alt="Imatge de perfil" class="profile-image" />
            <div class="profile-info">
                <h1 class="user-name">{{ user.name }}</h1>
                <p class="user-bio">{{ user.bio }}</p>
                <button class="edit-profile" @click="toggleEditProfile">Editar Perfil</button>
            </div>
        </div>

        <div v-if="isEditing" class="edit-profile-form">
            <h2>Editar Perfil</h2>
            <form @submit.prevent="saveChanges">
                <div>
                    <label for="name">Nombre de usuario:</label>
                    <input type="text" id="name" v-model="editedUser.name" maxlength="30" />
                </div>
                <div>
                    <label for="email">Email:</label>
                    <input type="email" id="email" v-model="editedUser.email" />
                </div>
                <div>
                    <label for="bio">Biografía:</label>
                    <textarea id="bio" v-model="editedUser.bio" maxlength="150"></textarea>
                </div>
                <div>
                    <label for="image">Foto de perfil:</label>
                    <input type="file" id="image" @change="onFileChange" />
                </div>
                <button type="submit">Guardar Cambios</button>
                <button type="button" @click="cancelEdit">Cancelar</button>
            </form>
        </div>

        <!-- Contenedor de estadísticas -->
        <div class="profile-stats">
            <div>
                <span class="stat-number">{{ user.posts }}</span>
                <p>Publicacions</p>
            </div>
            <div>
                <span class="stat-number">{{ user.followers }}</span>
                <p>Likes</p>
            </div>
            <div>
                <span class="stat-number">{{ user.following }}</span>
                <p>Guardats</p>
            </div>
        </div>

        <!-- Galería de publicaciones -->
        <div class="profile-gallery">
            <h2>Les teves publicacions</h2>
            <div class="gallery-grid">
                <div v-for="(post, index) in user.postsData" :key="index" class="gallery-item">
                    <img :src="post.image" :alt="'Post ' + (index + 1)" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { useAuthStore } from '../stores/useAuthStore.js';
import  communicationManager  from "./services/communicationManager.js";
import axios from 'axios';

export default {
    name: "Profile",
    data() {
        return {
            user: {
                name: "",
                bio: "",
                image: "",
                posts: 0,
                total_likes: 0,
                total_saves: 0,
                postsData: [],
            },
            isEditing: false,  // Controlar visibilidad del formulario de edición
            editedUser: {
                name: "",
                email: "",
                bio: "",
                image: null,  // Para almacenar la imagen antes de subirla
            }
        };
    },
    mounted() {
        this.fetchUserProfile();
    },
    methods: {
        async fetchUserProfile() {
            const authStore = useAuthStore();
            const token = authStore.token;

            if (!token) {
                console.error("No token found");
                return;
            }

            try {
                const response = await communicationManager.fetchProfileData(token);
                if (response.status === 200) {
                    this.user = {
                        name: response.data.user_name,
                        bio: response.data.user_description,
                        image: response.data.profile_image,
                        posts: response.data.post_count,
                        likes: response.data.total_likes,
                        saves: response.data.total_saves,
                        postsData: response.data.posts.map(post => ({
                            image: post.image,
                            title: post.title,
                        })),
                    };}
            } catch (error) {
                console.error("Error al obtener los datos del usuario:", error);
            }

            //Algo antiguo
                // try {
                //     const response = await fetch("http://localhost:8000/api/userStats", {
                //         method: "GET",
                //         headers: {
                //             "Authorization": `Bearer ${token}`,
                //             "Content-Type": "application/json",
                //         },
                //     });

                //     if (!response.ok) {
                //         throw new Error(`HTTP error! status: ${response.status}`);
                //     }

                //     const data = await response.json();
                //     console.log(data);

                //      this.user = {
                //          name: data.user_name,
                //          bio: data.user_description || "Aquest usuari no té cap descripció.",
                //          image: data.profile_image || "../../public/img/profile.jpeg",
                //          posts: data.post_count,
                //          followers: data.total_likes,
                //          following: data.total_saves,
                //          postsData: data.posts.map(post => ({
                //              image: post.image,
                //              title: post.title,
                //          })),
                //      };
                // } catch (error) {
                //     console.error("Error al obtener los datos del usuario:", error);
                // }
            },
            toggleEditProfile() {
                this.isEditing = !this.isEditing;
                // Pre-llenar el formulario con los datos actuales del usuario
                if (this.isEditing) {
                    this.editedUser = { ...this.user };
                }
            },
            onFileChange(event) {
                const file = event.target.files[0];
                this.editedUser.image = file;
            },
        async saveChanges() {
                const authStore = useAuthStore();
                const token = authStore.token;

                if (!token) {
                    console.error("No token found");
                    return;
                }

                const formData = new FormData();
                formData.append('name', this.editedUser.name);
                formData.append('email', this.editedUser.email);
                formData.append('bio', this.editedUser.bio);
                if (this.editedUser.image) {
                    formData.append('image', this.editedUser.image);
                }

                try {
                    const response = await fetch("http://localhost:8000/api/updateProfile", {
                        method: "POST",
                        headers: {
                            "Authorization": `Bearer ${token}`,
                        },
                        body: formData,
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const data = await response.json();
                    this.user = {
                        name: data.user.name,
                        bio: data.user.bio,
                        image: data.user.image,
                        posts: this.user.posts,
                        followers: this.user.followers,
                        following: this.user.following,
                        postsData: this.user.postsData,
                    };
                    this.isEditing = false;
                } catch (error) {
                    console.error("Error al actualizar el perfil:", error);
                }
            },
            cancelEdit() {
                this.isEditing = false;
            },
        },
    };
</script>

<style scoped>
/* Contenedor general */
.profile {
    max-width: 100%;
    margin: 0 auto;
    padding: 20px;
    font-family: Arial, sans-serif;
    color: #343330;
    /* Texto principal en jet */
}

/* Encabezado del perfil */
.profile-header {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 20px;
    margin-bottom: 20px;
}

.profile-image {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid lightgray;
}

.profile-info {
    text-align: center;
}

.user-name {
    font-size: 24px;
    font-weight: bold;
    margin: 0;
    color: #343330;
    /* Nombre del usuario en jet */
}

.user-bio {
    font-size: 14px;
    color: #343330;
    /* Texto bio en jet */
    margin: 10px 0;
}

.edit-profile {
    padding: 8px 16px;
    font-size: 14px;
    border: none;
    border-radius: 4px;
    background-color: #9ee37d;
    color: #343330;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.edit-profile:hover {
    background-color: #63c132;
}

/* Formulario de edición de perfil */
.edit-profile-form {
    background-color: #f7f7f7;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    max-width: 500px;
    margin: 20px auto;
}

.edit-profile-form h2 {
    font-size: 24px;
    color: #358600;
    font-weight: bold;
    margin-bottom: 15px;
    text-align: center;
}

.edit-profile-form label {
    display: block;
    font-size: 16px;
    color: #343330;
    margin-bottom: 5px;
}

.edit-profile-form input,
.edit-profile-form textarea {
    width: 100%;
    padding: 10px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 4px;
    margin-bottom: 15px;
    box-sizing: border-box;
}

.edit-profile-form input[type="file"] {
    padding: 5px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 4px;
    margin-bottom: 15px;
    box-sizing: border-box;
    background-color: #fff;
    color: #343330;
}

.edit-profile-form textarea {
    resize: vertical;
    height: 100px;
}

.edit-profile-form button {
    padding: 10px 20px;
    font-size: 16px;
    color: #fff;
    background-color: #63c132;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    width: 100%;
    margin-top: 10px;
}

.edit-profile-form button:hover {
    background-color: #9ee37d;
}

/* Botón de cancelar */
.edit-profile-form button[type="button"] {
    background-color: #ccc;
    margin-top: 10px;
}

.edit-profile-form button[type="button"]:hover {
    background-color: #aaa;
}


/* Estadísticas del perfil */
.profile-stats {
    display: flex;
    justify-content: space-around;
    border-top: 1px solid #343330;
    border-bottom: 1px solid #343330;
    padding: 10px 0;
    margin-bottom: 20px;
}

.stat-number {
    font-size: 18px;
    font-weight: bold;
    color: #63c132;
    /* Números en kelly-green */
}

.profile-stats p {
    margin: 0;
    font-size: 12px;
    color: #343330;
    /* Texto descriptivo en jet */
}

/* Galería de publicaciones */
.profile-gallery h2 {
    margin-bottom: 20px;
    font-size: 18px;
    font-weight: bold;
    color: #358600;
    /* Título en india-green */
}

.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
    gap: 10px;
}

.gallery-item {
    position: relative;
    overflow: hidden;
    width: 100%;
    height: 0;
    padding-bottom: 83.33%;
    /* Aspect ratio 4:3 */
    border-radius: 8px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease-in-out;
}

.gallery-item img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 8px;
    border-color: #343330;
}

.gallery-item img:hover {
    transform: scale(1.05);
}

/* Media queries para pantallas más grandes */
@media (min-width: 600px) {
    .profile-header {
        flex-direction: row;
        text-align: left;
    }

    .profile-info {
        text-align: left;
    }

    .gallery-grid {
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    }

    .gallery-item {
        height: 250px;
        padding-bottom: 0;
    }
}
</style>
