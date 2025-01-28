<template>
    <div class="profile">
        <!-- Encabezado del perfil -->
        <div class="profile-header">
            <img :src="user.image" alt="Imatge de perfil" class="profile-image" />
            <div class="profile-info">
                <h1 class="user-name">{{ user.name }}</h1>
                <p class="user-bio">{{ user.bio }}</p>
                <button class="edit-profile">Editar Perfil</button>
            </div>
        </div>

        <!-- Contenedor de estadísticas -->
        <div class="profile-stats">
            <div>
                <span class="stat-number">{{ user.posts }}</span>
                <p>Publicaciones</p>
            </div>
            <div>
                <span class="stat-number">{{ user.followers }}</span>
                <p>Seguidores</p>
            </div>
            <div>
                <span class="stat-number">{{ user.following }}</span>
                <p>Siguiendo</p>
            </div>
        </div>

        <!-- Galería de publicaciones -->
        <div class="profile-gallery">
            <h2>Tus publicaciones</h2>
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

export default {
    name: "Profile",
    data() {
        return {
            user: {
                name: "",
                bio: "",
                image: "",
                posts: 0,
                followers: 0,
                following: 0,
                postsData: [],
            },
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
                const response = await fetch("http://localhost:8000/api/userStats", {
                    method: "GET",
                    headers: {
                        "Authorization": `Bearer ${token}`,
                        "Content-Type": "application/json",
                    },
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                console.log(data);
                
                // this.user = {
                //     name: data.user_name,
                //     bio: data.user_description,
                //     image: data.profile_image,
                //     posts: data.post_count,
                //     followers: data.total_likes,
                //     following: data.total_saves,
                //     postsData: data.posts.map(post => ({
                //         image: post.image,
                //         title: post.title,
                //     })),
                // };
            } catch (error) {
                console.error("Error al obtener los datos del usuario:", error);
            }
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
