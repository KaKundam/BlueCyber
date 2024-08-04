#include <stdio.h>
#include <stdlib.h>
#include <string.h>

int set_password(const char *username, const char *password) {
    char command[256];
    snprintf(command, sizeof(command), "echo %s:%s | sudo chpasswd", username, password);

    int result = system(command);

    if (result == -1) {
        fprintf(stderr, "Failed to execute command.\n");
        return 1;
    } else if (WIFEXITED(result) && WEXITSTATUS(result) != 0) {
        fprintf(stderr, "Command exited with status %d.\n", WEXITSTATUS(result));
        return 1;
    }

    return 0;
}

int main(int argc, char *argv[]) {
    if (argc != 3) {
        fprintf(stderr, "Usage: %s <username> <password>\n", argv[0]);
        return 1;
    }

    const char *username = argv[1];
    const char *password = argv[2];

    if (set_password(username, password) == 0) {
        printf("Password for user %s changed successfully.\n", username);
    } else {
        fprintf(stderr, "Failed to change password for user %s.\n", username);
    }

    return 0;
}
