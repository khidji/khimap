<?php

// CODE DE DAVID DRAGON POUR LE TP AUTHENTIFICATION


function validateForm(array $post, $isLoggingIn = false): array{
  // ce tableau servira a stocker nos potentielles erreurs
  $errors = [];

  // on boucle sur le tableau pour vérifier toutes les entrées
  foreach ($post as $key => $value) {
    // si pas de valeur on crée une entrée dans le tableau $errors qui aura pour clé, la valeur courante de $key
    if (!$value) {
      $errors[$key] = 'Ce champs ne peut pas être vide.';
    } else {
      // si l'utilisateur n'est pas sur un formulaire de connexion
      if (!$isLoggingIn) {
        // on vérifie que l'email et le mot de passe correspondent à certains critères
        // s'ils ne correspondent pas on viendra créer dans le tableau $errors une nouvelle clé avec une valeur associée en indiquant le problème
        if ($key === 'email') {
          // preg_match permet de vérifier la cooncordance entre une regexp et une valeur
          if (!preg_match("/^\S+@\S+\.\S+/", $value)) {
            $errors['email'] = "Cet email n'est pas un email valide.";
          }
        } elseif ($key === 'password') {
          if (!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-\/+_]).{8,}$/", $value)) {
            $errors['password'] = "Votre mot de passe est trop faible.";
          }
        }
      }
    }
  }

  // dans tout les cas on renvoie le tableau d'erreurs (vide ou non)
  return $errors;
}