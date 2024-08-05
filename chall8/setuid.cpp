#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>

int main() {
    uid_t target_uid = 1002; // Thay thế bằng UID của user2
    

    if (setuid(target_uid) == -1) {
        perror("setuid");
        exit(EXIT_FAILURE);
    }

    system("id");

    return 0;
}
