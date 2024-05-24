#include <iostream>
#include <windows.h>
using namespace std;
int main(int argc,char *argv[])
{
    if (argc!=3) return 1;
    //LPCSTR s,tv;
    //LoadLibraryA("C:\\Users\\qhung\\Downloads\\Job\\BlueCyber\\chall3\\ImDLL\\bin\\Debug\\ImDLL.dll");
    HMODULE t=LoadLibraryA(argv[1]);
    FARPROC ans=GetProcAddress(t,argv[2]);
    ans();
}
