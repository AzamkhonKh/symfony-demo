# **Scaffold Symfony API App with Sample Model, Controller, Service, and Docker File**

This repository provides a scaffolded Symfony API application with Docker support. It includes a sample Product model, controller, and service, as well as useful commands for managing your application efficiently.

---

## **Features**
- Pre-configured Docker environment for PHP and Composer services.
- Symfony API structure with a sample `Product` entity, CRUD operations, and validation.
- Predefined `Makefile` commands for common tasks, including PHPUnit testing, migrations, and Composer management.
- Easily extensible structure for adding more models and services.

---

## **Getting Started**

### **Prerequisites**
Ensure you have the following installed on your machine:
- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)

---

### **Setup**

1. Clone the repository:
   ```bash
   git clone <repository-url>
   cd <repository-directory>
   ```

2. Build and start the Docker containers:
   ```bash
   make up
   ```

3. Install PHP dependencies using Composer:
   ```bash
   make composer-install
   ```

4. Run database migrations:
   ```bash
   make migrations-migrate
   ```

5. Start developing your API!

---

## **Commands Reference**

### **Docker-Related Commands**
| Command         | Description                                 |
|-----------------|---------------------------------------------|
| `make up`       | Starts Docker containers in detached mode. |

### **Composer Commands**
| Command                | Description                                                                 |
|------------------------|-----------------------------------------------------------------------------|
| `make composer-install`| Installs PHP dependencies via Composer.                                    |
| `make composer-require package=<package>` | Adds a new Composer dependency. Replace `<package>` with the desired package name. |

### **PHPUnit Testing**
| Command       | Description                     |
|---------------|---------------------------------|
| `make phpunit`| Runs PHPUnit tests.            |

### **Symfony Commands**
| Command                          | Description                                                             |
|----------------------------------|-------------------------------------------------------------------------|
| `make console cmd=<command>`     | Runs any Symfony console command. Replace `<command>` with the command. |
| `make migrations-make`           | Creates a new Doctrine migration.                                       |
| `make migrations-migrate`        | Executes pending database migrations.                                   |

---

## **Project Structure**

```plaintext
.
├── src/
│   ├── Controller/    # API Controllers
│   ├── Entity/        # Doctrine Entities
│   ├── Repository/    # Doctrine Repositories
│   ├── Service/       # Business Logic Services
│   └── DTO/           # Data Transfer Objects (for validation)
├── tests/             # PHPUnit Tests
├── docker-compose.yml # Docker Configuration
└── Makefile           # Shortcut Commands
```

---

## **Sample API Endpoints**

### **Product Resource**
| HTTP Method | Endpoint          | Description              |
|-------------|-------------------|--------------------------|
| `GET`       | `/api/products`   | List all products.       |
| `POST`      | `/api/products`   | Create a new product.    |
| `GET`       | `/api/products/{id}` | Get a specific product. |
| `PUT`       | `/api/products/{id}` | Update a specific product. |
| `DELETE`    | `/api/products/{id}` | Delete a specific product. |

---

## **Testing**
Run the test suite using PHPUnit:
```bash
make phpunit
```

---

## **Contributing**
Feel free to fork this repository and submit pull requests for improvements or new features.

---

## **License**
This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.