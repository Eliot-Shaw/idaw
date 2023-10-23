swagger: '2.0'
info:
  version: 1.0.0
  title: Swagger User API
  description: >-
    Cette API permet de gérer les utilisateurs et offre des fonctionnalités de liste, création, mise à jour et suppression d'utilisateurs.
schemes:
  - http
consumes:
  - application/json
produces:
  - application/json
paths:
  /users:
    get:
      description: Récupérer la liste des utilisateurs
      produces:
        - application/json
      responses:
        '200':
          description: Une liste d'utilisateurs.
          schema:
            type: array
            items:
              $ref: '#/definitions/User'
        '404':
          description: Aucun utilisateur trouvé.
        '405':
          description: Methode non-autorisée.
        '500':
          description: Erreur interne du serveur lors de la création de l'utilisateur.
    post:
      description: Créer un nouvel utilisateur
      consumes:
        - application/json
      produces:
        - application/json
      parameters:
        - in: body
          name: user
          schema:
            $ref: '#/definitions/User'
      responses:
        '200':
          description: Utilisateur créé avec succès.
        '404':
          description: Aucun utilisateur trouvé.
        '405':
          description: Methode non-autorisée.
        '500':
          description: Erreur interne du serveur lors de la création de l'utilisateur.
    put:
      description: Mettre à jour un utilisateur existant
      consumes:
        - application/json
      produces:
        - application/json
      parameters:
        - in: body
          name: user
          schema:
            $ref: '#/definitions/User'
      responses:
        '200':
          description: Utilisateur mis à jour avec succès.
        '404':
          description: Aucun utilisateur trouvé.
        '405':
          description: Methode non-autorisée.
        '500':
          description: Erreur interne du serveur lors de la mise à jour de l'utilisateur.
    delete:
      description: Supprimer un utilisateur
      consumes:
        - application/json
      produces:
        - application/json
      parameters:
        - in: body
          name: user
          schema:
            $ref: '#/definitions/User'
      responses:
        '200':
          description: Utilisateur supprimé avec succès.
        '404':
          description: Aucun utilisateur trouvé.
        '405':
          description: Methode non-autorisée.
        '500':
          description: Erreur interne du serveur lors de la suppression de l'utilisateur.
  /user/id:
    get:
      description: Récupérer un seul utilisateur
      produces:
        - application/json
      responses:
        '200':
          description: Un utilisateur.
          schema:
            type: array
            items:
              $ref: '#/definitions/User'
        '404':
          description: Aucun utilisateur trouvé.
        '405':
          description: Methode non-autorisée.
        '500':
          description: Erreur interne du serveur lors de la suppression de l'utilisateur.
definitions:
  User:
    type: object
    required:
      - name
      - email
    properties:
      name:
        type: string
      email:
        type: string
