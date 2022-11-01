for i in *.gif; do
    # untuk ambil nama folder nya
    get=${i:16:-4};
    folder=${get//_/};

    #sekarang ambil untuk nama filenya
    get2=${i:9:-4};
    get3=${get2:0:7};
    nama=${get3//_/};

    # baru pindahkan ke foldernya masing-masing
    [ ! -d "$folder" ] && { mkdir "$folder"; }
    mv -- "$i" "$folder/$nama.gif";

done

