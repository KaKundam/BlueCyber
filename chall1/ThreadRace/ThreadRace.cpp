/**
Đoạn code này được em chỉnh sửa lại code của AI vì thời gian
không đủ để nghiên cứu cũng như sự bất lực trong việc xem xét
các tham số của các hàm trong winapi
Đoạn code được sắp xếp theo số lượng "công việc" mà một thread
đã làm được vì khối lượng "công việc" càng nhiều thì thời gian
làm được càng lớn
**/

#include <iostream>
#include <windows.h>
#include <thread>
#include <chrono>
#include <fstream>
#include <tlhelp32.h>

using namespace std;

// Hàm đếm số từ trong file
DWORD WINAPI CountWords(LPVOID lpParam) {
    const char* filename = "1.txt";
    ifstream file(filename);
    string word;
    int Count = 0;
    while (file >> word) {
        Count++;
    }
    return Count;
}

// Hàm đếm số file trong thư mục hiện tại
DWORD WINAPI CountFiles(LPVOID lpParam) {
    WIN32_FIND_DATA findFileData;
    HANDLE hFind = FindFirstFile("*.*", &findFileData);
    if (hFind != INVALID_HANDLE_VALUE) {
        int Count = 0;
        do {
            if (findFileData.dwFileAttributes & FILE_ATTRIBUTE_NORMAL)
                Count++;
        } while (FindNextFile(hFind, &findFileData) != 0);
        FindClose(hFind);
        return Count;
    } else {
        cerr << "Không thể tìm thấy file trong thư mục hiện tại" << endl;
        return 0;
    }
}

// Hàm đếm số thread của process explorer.exe
DWORD WINAPI CountExplorerThreads(LPVOID lpParam) {
    DWORD processId = GetCurrentProcessId();
    HANDLE hSnapshot = CreateToolhelp32Snapshot(TH32CS_SNAPTHREAD, 0);
    if (hSnapshot != INVALID_HANDLE_VALUE) {
        THREADENTRY32 te32;
        te32.dwSize = sizeof(THREADENTRY32);
        DWORD Count = 0;
        if (Thread32First(hSnapshot, &te32)) {
            do {
                if (te32.th32OwnerProcessID == processId) {
                    Count++;
                }
            } while (Thread32Next(hSnapshot, &te32));
        }
        CloseHandle(hSnapshot);
        return Count;
    } else {
        cerr << "Không thể tạo snapshot của thread" << endl;
        return 0;
    }
}

int main() {
    HANDLE hThreads[3];
    DWORD threadResults[3];
    int pos[]={0,1,2};
    // Tạo các thread
    hThreads[0] = CreateThread(NULL, 0, CountWords, NULL, 0, NULL);
    hThreads[1] = CreateThread(NULL, 0, CountFiles, NULL, 0, NULL);
    hThreads[2] = CreateThread(NULL, 0, CountExplorerThreads, NULL, 0, NULL);

    // Đợi cho tất cả các thread kết thúc
    WaitForMultipleObjects(3, hThreads, TRUE, INFINITE);

    // Lấy kết quả của từng thread
    GetExitCodeThread(hThreads[0], &threadResults[0]);
    GetExitCodeThread(hThreads[1], &threadResults[1]);
    GetExitCodeThread(hThreads[2], &threadResults[2]);

    for (int i=0;i<3;i++)
        for (int j=0;j<i;j++)
            if (threadResults[pos[j]]>threadResults[pos[j+1]]) swap(pos[j],pos[j+1]);

    cout<<"Thread "<<pos[0]+1<<": Giải nhất\n";
    cout<<"Thread "<<pos[1]+1<<": Giải nhì\n";
    cout<<"Thread "<<pos[2]+1<<": Giải ba\n";


    // Xóa handles của các thread
    for (int i = 0; i < 3; ++i) {
        CloseHandle(hThreads[i]);
    }

    return 0;
}
