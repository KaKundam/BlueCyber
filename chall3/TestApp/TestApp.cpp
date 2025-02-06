#include <iostream>
#include <windows.h>
using namespace std;
int main(int argc,char *argv[])
{
//    const LPCSTR sometext="Dont Know What string for what";
//    MessageBoxA(0, sometext, "Hi! Im DLL", MB_OK | MB_ICONINFORMATION);
    if (argc!=3) return 1;
    //LPCSTR s,tv;
//    HMODULE t=LoadLibraryA("C:\\Users\\qhung\\Desktop\\CP\\ImDLL\\bin\\Debug\\ImDLL.dll");
//    FARPROC ans=GetProcAddress(t,"SomeFunction");
    HMODULE t=LoadLibraryA(argv[1]);
    FARPROC ans=GetProcAddress(t,argv[2]);
    ans();
}
