#include <iostream>
#include <string.h>
#include <windows.h>
#include <stdio.h>
#include <tlhelp32.h>

void Terminate(int PID) // xoa 1 process bang PID
{
    DWORD processID = PID;
    HANDLE hProcess = OpenProcess(PROCESS_TERMINATE, FALSE, processID);

    if (hProcess == NULL) {
        if (GetLastError()==87){
            printf("The process %d has not found",PID);
        }
        else{
            printf("OpenProcess failed, error %d\n",GetLastError());
        }
        return ;
    }

    if (!TerminateProcess(hProcess,0)) {
        printf("TerminateProcess failed, error %d\n",GetLastError());
        CloseHandle(hProcess);
        return ;
    }

    printf("Process has been delete!");
    CloseHandle(hProcess);
}
int main()
{
    printf("Do you want to kill process with PID(1) or Image Name(2) (Press 1 or 2):");
    int type;
    std::cin>>type;
    if (type==1){
        printf("Press PID: ");
        std::cin>>type;
        Terminate(type);
    }
    else{
        printf("Press image name of process:");
        std::string ProcessName;
        std::cin>>ProcessName;


        // Duyet qua tat ca cac process de tim theo ten

        HANDLE hProcessSnap;
        PROCESSENTRY32 pe32;

        hProcessSnap=CreateToolhelp32Snapshot(TH32CS_SNAPPROCESS, 0);
        pe32.dwSize=sizeof(PROCESSENTRY32);

        if (!Process32First(hProcessSnap, &pe32)) {
            CloseHandle(hProcessSnap);
            return 1;
        }
        type=-1;
        do {
            if (pe32.szExeFile==ProcessName){
                type=pe32.th32ProcessID;
                break;
            }
        } while (Process32Next(hProcessSnap, &pe32));

        if (type==-1){ // ko tim duoc process
            printf("Can not find this process");
            return 1;
        }

        Terminate(type);
        CloseHandle(hProcessSnap);
    }
    return 0;
}
