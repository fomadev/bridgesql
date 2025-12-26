# Guide de Contribution

Merci de votre intérêt pour contribuer à BridgeSQL ! Ce document fournit des directives pour contribuer au projet.

## 🚀 Démarrage rapide

1. **Fork** le projet
2. **Clone** votre fork : `git clone https://github.com/fomadev/BridgeSQL.git`
3. **Créez une branche** pour votre fonctionnalité : `git checkout -b feature/ma-fonctionnalite`
4. **Installez les dépendances** : `composer install`

## 📝 Standards de code

### Style de code
- Suivez les standards **PSR-12** pour le style de code PHP
- Utilisez des **espaces** (4 espaces) pour l'indentation, pas de tabulations
- Ajoutez une ligne vide à la fin de chaque fichier

### Documentation
- Documentez toutes les méthodes publiques avec **PHPDoc**
- Incluez des exemples dans la documentation quand c'est pertinent
- Mettez à jour le `README.md` si vous ajoutez de nouvelles fonctionnalités

### Exemples
- Créez des exemples dans `examples/` pour les nouvelles fonctionnalités
- Assurez-vous que les exemples fonctionnent et sont bien documentés
- Suivez le style des exemples existants

## 🧪 Tests

- Ajoutez des tests pour les nouvelles fonctionnalités dans `tests/`
- Assurez-vous que tous les tests passent avant de soumettre une pull request
- Testez avec différentes versions de PHP (>= 8.0)

## 📦 Structure des commits

Utilisez des messages de commit clairs et descriptifs :

```
feat: Ajout de la méthode fetchColumn()
fix: Correction du binding des paramètres NULL
docs: Mise à jour de la documentation des transactions
refactor: Amélioration de la gestion des erreurs
```

### Types de commits
- `feat` : Nouvelle fonctionnalité
- `fix` : Correction de bug
- `docs` : Documentation uniquement
- `style` : Formatage, point-virgule manquant, etc.
- `refactor` : Refactorisation du code
- `test` : Ajout ou modification de tests
- `chore` : Maintenance, dépendances, etc.

## 🔀 Processus de Pull Request

1. **Assurez-vous** que votre code suit les standards
2. **Testez** votre code localement
3. **Mettez à jour** le `CHANGELOG.md` avec vos changements
4. **Créez** une pull request avec une description claire
5. **Répondez** aux commentaires et suggestions

### Template de Pull Request

```markdown
## Description
Brève description de ce que fait cette PR.

## Type de changement
- [ ] Nouvelle fonctionnalité
- [ ] Correction de bug
- [ ] Amélioration de la documentation
- [ ] Refactorisation

## Tests
Comment avez-vous testé ces changements ?

## Checklist
- [ ] Mon code suit les standards du projet
- [ ] J'ai ajouté des tests pour les nouvelles fonctionnalités
- [ ] J'ai mis à jour la documentation
- [ ] J'ai mis à jour le CHANGELOG.md
```

## 🐛 Signaler un bug

Si vous trouvez un bug, veuillez créer une issue avec :

1. **Description claire** du bug
2. **Étapes pour reproduire** le problème
3. **Comportement attendu** vs comportement actuel
4. **Version PHP** et environnement
5. **Code d'exemple** si possible

## 💡 Proposer une fonctionnalité

Pour proposer une nouvelle fonctionnalité :

1. Créez une issue avec le label `enhancement`
2. Décrivez la fonctionnalité et son utilité
3. Expliquez comment elle s'intègre dans le projet
4. Attendez les retours avant de commencer à coder

## 📚 Ressources

- [PSR-12 Coding Style Guide](https://www.php-fig.org/psr/psr-12/)
- [PSR-4 Autoloading Standard](https://www.php-fig.org/psr/psr-4/)
- [Semantic Versioning](https://semver.org/)

## ❓ Questions ?

Si vous avez des questions, n'hésitez pas à :
- Ouvrir une issue
- Contacter les mainteneurs du projet

Merci de contribuer à BridgeSQL ! 🎉

