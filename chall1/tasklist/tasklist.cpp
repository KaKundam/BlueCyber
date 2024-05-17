#include <windows.h>
#include <iostream>
#include <tlhelp32.h>
#include <tchar.h>

int main() {
    HANDLE hProcessSnap;
    PROCESSENTRY32 pe32;

    hProcessSnap=CreateToolhelp32Snapshot(TH32CS_SNAPPROCESS, 0);
    pe32.dwSize=sizeof(PROCESSENTRY32);

    if (!Process32First(hProcessSnap, &pe32)) {
        CloseHandle(hProcessSnap);
        return 1;
    }


    do {
        printf("\n\n=====================================================");
        printf("\nPROCESS NAME:  %s", pe32.szExeFile);
        printf("\n-----------------------------------------------------");
        printf("\n  Process ID        = %d", pe32.th32ProcessID);
        printf("\n  Thread count      = %d", pe32.cntThreads);
        printf("\n  Parent process ID = %d", pe32.th32ParentProcessID);
    } while (Process32Next(hProcessSnap, &pe32));

    CloseHandle(hProcessSnap);
    return 0;
}
