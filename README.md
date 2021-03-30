# MVF coding exercise

### Requirements:
-   `docker`
-   `make`

### Usage:
-   Install dependencies:
    ```shell script
    make install
    ```

-   Build docker image:
    ```shell script
    make build
    ```
    
-   Run tests:
    ```shell script
    make test
    ```

### Run:

```shell script
make run USERNAME="github-username"
```
or
```shell script
php -f index.php github-username
```

### Notes

- I've used https://github.com/KnpLabs/php-github-api library for Github API calls
- I haven't used any frameworks because the task is very small and doesn't require any framework libs

### Assumptions/Limitations

- I've created a model for GitHubRepository with only one field (`language`) as I don't need any other fields for this task
