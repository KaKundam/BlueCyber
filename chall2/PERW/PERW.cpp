#include <windows.h>
#include <iostream>
#include <vector>
using namespace std;
void PrintMemoryInfo(DWORD processID) {
    HANDLE hProcess=OpenProcess(PROCESS_QUERY_INFORMATION | PROCESS_VM_READ, FALSE, processID);
    if (hProcess == NULL) {
        cerr<<"OpenProcess failed. Error: "<<GetLastError()<<endl;
        return ;
    }

    MEMORY_BASIC_INFORMATION mbi;
    vector<char> buffer;
    SIZE_T bytesRead;
    LPVOID address=0;

    cout<<"Memory regions with PAGE_EXECUTE_READWRITE protection:"<<endl;

    while (VirtualQueryEx(hProcess, address, &mbi, sizeof(mbi))) {
        if (mbi.Protect == PAGE_EXECUTE_READWRITE) {
            cout<<"Base Address: "<<mbi.BaseAddress
                     <<", Region Size: "<<mbi.RegionSize<<endl;
        }
        address=(LPBYTE)mbi.BaseAddress + mbi.RegionSize;
    }

    CloseHandle(hProcess);
}

int main(int argv, const char *argc) {
    DWORD processID;
    cout<<"Input processID: ";
    cin>>processID;
    PrintMemoryInfo(processID);
    return 0;
}

//#include <iostream>
//#include <windows.h>
//using namespace std;
//int main(int argc, char **argv)
//{
//    if(argc == 2)
//    {
//        HANDLE hProcess = OpenProcess(PROCESS_ALL_ACCESS, FALSE, stoll(argv[1]));
//        if (hProcess == NULL)
//        {
//            cout << "Failed to open process.\n";
//        }
//        SYSTEM_INFO systemInfo;
//        GetSystemInfo(&systemInfo);
//        MEMORY_BASIC_INFORMATION memoryInfo;
//        LPVOID memoryAddress = systemInfo.lpMinimumApplicationAddress;
//        while (memoryAddress < systemInfo.lpMaximumApplicationAddress)
//        {
//            if (VirtualQueryEx(hProcess, memoryAddress, &memoryInfo, sizeof(memoryInfo)))
//            {
//                if (memoryInfo.Protect == PAGE_EXECUTE_READWRITE)
//                {
//                    cout << "Base Address: " << memoryInfo.BaseAddress << endl;
//                    cout << "Allocation Base: " << memoryInfo.AllocationBase << endl;
//                    cout << "Allocation Protect: " << memoryInfo.AllocationProtect << endl;
//                    cout << "State: " << memoryInfo.State << endl;
//                    cout << "Protect: " << memoryInfo.Protect << endl;
//                    cout << "Type: " << memoryInfo.Type << endl;
//                }
//                memoryAddress = static_cast<LPVOID>(static_cast<char *>(memoryAddress) + memoryInfo.RegionSize);
//            }
//            else
//            {
//                break;
//            }
//        }
//        CloseHandle(hProcess);
//    }
//    else if(argc != 2)
//    {
//        cout << "Error!";
//    }
//}
