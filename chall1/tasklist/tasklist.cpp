#include <windows.h>
#include <tlhelp32.h>
#include <iostream>
#include <iomanip>

void PrintProcessTable() {
    HANDLE hSnapshot = CreateToolhelp32Snapshot(TH32CS_SNAPPROCESS, 0);
    if (hSnapshot == INVALID_HANDLE_VALUE) {
        std::cerr << "Không thể tạo snapshot" << std::endl;
        return;
    }

    PROCESSENTRY32 pe32;
    pe32.dwSize = sizeof(PROCESSENTRY32);

    if (!Process32First(hSnapshot, &pe32)) {
        std::cerr << "Không thể lấy thông tin tiến trình" << std::endl;
        CloseHandle(hSnapshot);
        return;
    }

    std::cout << std::left << std::setw(35) << "Process Name"
              << std::setw(10) << "PID"
              << std::setw(15) << "Thread Count"
              << std::setw(15) << "Parent PID" << std::endl;
    std::cout << "---------------------------------------------------------------" << std::endl;

    do {
        std::cout << std::left << std::setw(35) << pe32.szExeFile
                  << std::setw(10) << pe32.th32ProcessID
                  << std::setw(15) << pe32.cntThreads
                  << std::setw(15) << pe32.th32ParentProcessID << std::endl;
    } while (Process32Next(hSnapshot, &pe32)); // Lặp lại cho các tiến trình tiếp theo

    CloseHandle(hSnapshot); // Giải phóng handle snapshot
}

int main() {
    PrintProcessTable(); // Gọi hàm in bảng tiến trình
    return 0;
}
