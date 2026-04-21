# Contributing Guide

Thank you for your interest in contributing to BridgeSQL. This document provides the necessary guidelines to ensure a consistent and efficient contribution process.

## Quick Start

1. **Fork** the repository on GitHub.
2. **Clone** your fork locally: `git clone https://github.com/fomadev/BridgeSQL.git`
3. **Create a branch** for your feature or fix: `git checkout -b feature/your-feature-name`
4. **Install dependencies**: Execute `composer install` to set up the development environment.

## Code Standards

### Coding Style
- Adhere strictly to **PSR-12** coding standards.
- Use **4 spaces** for indentation (no tabs).
- Ensure every file ends with a single empty line.

### Documentation
- All public methods must be documented using **PHPDoc** blocks.
- Provide inline comments for complex logic.
- Update the `README.md` if you introduce new features or change existing behavior.

### Examples
- Add relevant scripts to the `examples/` directory for any new functionality.
- Ensure all examples are functional and follow the existing naming convention (e.g., `feature_name_example.php`).

## Testing

- New features must include corresponding unit tests in the `tests/` directory.
- All existing and new tests must pass before submitting a pull request.
- Verify compatibility with PHP versions >= 8.0.

## Commit Structure

BridgeSQL follows a structured commit message format to maintain a clear project history:

### Commit Types
- `feat`: A new feature.
- `fix`: A bug fix.
- `docs`: Documentation changes only.
- `style`: Changes that do not affect the meaning of the code (white-space, formatting, etc.).
- `refactor`: A code change that neither fixes a bug nor adds a feature.
- `test`: Adding missing tests or correcting existing tests.
- `chore`: Maintenance tasks or dependency updates.

## Pull Request Process

1. Verify that your code complies with the project's standards.
2. Run all tests locally.
3. Update the `CHANGELOG.md` to reflect your changes.
4. Submit the pull request with a comprehensive description of the modifications.
5. Address any feedback or requested changes from the maintainers.

### Pull Request Template

```markdown
## Description
A concise summary of the changes introduced by this PR.

## Type of Change
- [ ] New feature
- [ ] Bug fix
- [ ] Documentation update
- [ ] Refactoring

## Testing
Describe the methods used to test these changes.

## Checklist
- [ ] My code follows the project's coding standards.
- [ ] I have added tests for the new functionality.
- [ ] I have updated the documentation accordingly.
- [ ] I have updated the CHANGELOG.md.
```

## Reporting Issues

To report a bug, please open a GitHub Issue including:

1. A clear and descriptive title.

2. Detailed steps to reproduce the issue.

3. The expected vs. actual behavior.

4. Your PHP version and environment details.

5. A code snippet demonstrating the problem.

## Feature Requests

For new feature proposals:

1. Open an issue with the enhancement label.

2. Explain the utility and implementation strategy of the feature.

3. Wait for maintainer feedback before proceeding with the code.

## Resources

[PSR-12 Coding Style Guide](https://www.php-fig.org/psr/psr-12/)

[PSR-4 Autoloading Standard](https://www.php-fig.org/psr/psr-4/)

[Semantic Versioning](https://semver.org/)

## Contact
For further inquiries, please open an issue or contact the project maintainers directly.

Thank you for contributing to BridgeSQL.