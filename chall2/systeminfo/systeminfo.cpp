#include <windows.h>
#include <iostream>

void PrintSystemInfo() {
    SYSTEM_INFO siSysInfo;

    // Lấy thông tin phần cứng và lưu vào cấu trúc SYSTEM_INFO.
    GetSystemInfo(&siSysInfo);

    // Hiển thị thông tin phần cứng.
    std::cout << "Hardware information: " << std::endl;
    std::cout << "  OEM ID: " << siSysInfo.dwOemId << std::endl;
    std::cout << "  Number of processors: " << siSysInfo.dwNumberOfProcessors << std::endl;
    std::cout << "  Page size: " << siSysInfo.dwPageSize << std::endl;
    std::cout << "  Processor type: " << siSysInfo.dwProcessorType << std::endl;
    std::cout << "  Minimum application address: " << siSysInfo.lpMinimumApplicationAddress << std::endl;
    std::cout << "  Maximum application address: " << siSysInfo.lpMaximumApplicationAddress << std::endl;
    std::cout << "  Active processor mask: " << siSysInfo.dwActiveProcessorMask << std::endl;
}

int main() {
    PrintSystemInfo();
    return 0;
}
